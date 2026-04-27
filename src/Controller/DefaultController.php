<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Promo;
use App\Entity\Testimony;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function indexAction(EntityManagerInterface $em): RedirectResponse|Response
    {
        $now = new \DateTime();
        $events = $em->getRepository(Article::class)
            ->createQueryBuilder('a')
            ->where('a.publishedAt IS NOT NULL AND a.publishedAt <= :date')
            ->andWhere('a.expiresAt IS NULL OR a.expiresAt > :date')
            ->setParameter('date', $now)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();

        $promoOpen = $em->getRepository(Promo::class)
            ->createQueryBuilder('p')
            ->where('p.registeringStart <= :date')
            ->andWhere('p.registeringEnd >= :date')
            ->andWhere('p.helloAssoFormLink IS NOT NULL')
            ->setParameter('date', $now)
            ->orderBy('p.start', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        $requiredPromoTestimonies = $em->getRepository(Testimony::class)
            ->createQueryBuilder('t')
            ->where('t.promo = 1')
            ->andWhere('t.requiredDisplaying = 1')
            ->orderBy('RAND()')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();

        $nbRequiredTestmonies = \count($requiredPromoTestimonies);

        if ($nbRequiredTestmonies < 6) {
            $promoTestimonies = $em->getRepository(Testimony::class)
                ->createQueryBuilder('t')
                ->where('t.promo = 1')
                ->andWhere('t.requiredDisplaying = 0')
                ->orderBy('RAND()')
                ->setMaxResults(6 - $nbRequiredTestmonies)
                ->getQuery()
                ->getResult();
        } else {
            $promoTestimonies = [];
        }

        return $this->render('default/index.html.twig', [
            'events' => $events,
            'requiredPromoTestimonies' => $requiredPromoTestimonies,
            'promoTestimonies' => $promoTestimonies,
            'promoOpen' => $promoOpen,
        ]);
    }

    #[Route('/promos', name: 'promos')]
    public function promosAction(EntityManagerInterface $em): Response
    {
        $now = new \DateTime();
        $availablePromos = $em->getRepository(Promo::class)
            ->createQueryBuilder('p')
            ->where('p.helloAssoFormLink IS NOT NULL')
            ->andWhere('p.registeringStart <= :date')
            ->andWhere('p.registeringEnd >= :date')
            ->setParameter('date', $now)
            ->orderBy('p.start', 'ASC')
            ->getQuery()
            ->getResult();

        $otherPromos = $em->getRepository(Promo::class)
            ->createQueryBuilder('p')
            ->where('p.start >= :date')
            ->andWhere('p.registeringStart >= :date')
            ->setParameter('date', $now)
            ->orderBy('p.start', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('default/promos.html.twig', [
            'promos' => $availablePromos,
            'otherPromos' => $otherPromos,
        ]);
    }

    #[Route('/nous-soutenir', name: 'support')]
    public function supportAction(): Response
    {
        return $this->render('default/support.html.twig');
    }

    #[Route('/mentions-legales', name: 'legals')]
    public function legalsAction(): Response
    {
        return $this->render('default/legals.html.twig');
    }

    #[Route('/calendrier', name: 'calendar')]
    public function calendarAction(): Response
    {
        return $this->render('default/calendar.html.twig');
    }

    #[Route('/l-explorateur-guide-de-l-emploi', name: 'guide')]
    public function guideAction(): Response
    {
        return $this->render('default/guide.html.twig');
    }

    #[Route('/partenaires', name: 'partners')]
    public function partnersAction(): Response
    {
        return $this->render('default/partners.html.twig');
    }

    #[Route('/evenement/{slug:event}', name: 'event_show')]
    public function eventShowAction(Event $event): Response
    {
        return $this->render('default/event_show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/promo/{id}/get-ical', name: 'promo_get_ical')]
    public function promoGetICalAction(Request $request, Promo $promo): Response
    {
        return $this->getResponseIcal(
            $request,
            $promo->getStart()->setTime(0, 0, 0),
            $promo->getEnd()->setTime(23, 30, 0),
            'Cojob Nantes '.$promo->getName()
        );
    }

    #[Route('/promo/registration/{id}/get-ical', name: 'promo_registration_get_ical')]
    public function promoRegistrationGetICalAction(Request $request, Promo $promo): Response
    {
        return $this->getResponseIcal(
            $request,
            $promo->getRegisteringStart()->setTime(0, 0, 0),
            $promo->getRegisteringStart()->setTime(23, 30, 0),
            'Ouverture inscriptions Cojob Nantes '.$promo->getName()
        );
    }

    #[Route('/contact', name: 'contact')]
    public function contactAction(Request $request, MailerInterface $mailer, EntityManagerInterface $em, TranslatorInterface $translator, LoggerInterface $logger): RedirectResponse|Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            if ($contact->getName()) {
                $this->addFlash(
                    'contact.danger',
                    'contact.spam'
                );
                $logger->info('SPAM detected', [
                    'contact' => $contact,
                    'email' => $contact->getEmail(),
                    'tel' => $contact->getTelephone(),
                    'pot' => $contact->getName(),
                    'message' => $contact->getMessage(),
                ]);
            } else {
                $em->persist($contact);
                $em->flush();

                $mailerParam = $this->getParameter('app.mailer');

                $email = new TemplatedEmail()
                    ->from($mailerParam['from'])
                    ->to($mailerParam['to'])
                    ->bcc($mailerParam['default_bcc'])
                    ->subject($translator->trans('contact.email.subject').' : '.$contact->getFirstName().' '.$contact->getLastName())
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context([
                        'data' => $contact,
                    ])
                ;

                $mailer->send($email);

                $this->addFlash(
                    'contact.success',
                    'gtag(\'event\', \'contact-form-homepage\');'
                );
            }

            return $this->redirect($this->generateUrl('contact').'#contact');
        }

        return $this->render('default/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }

    private function getResponseIcal(Request $request, $start, $end, $summary): Response
    {
        $vEvent = new \Eluceo\iCal\Domain\Entity\Event();

        $vEvent->setSummary($summary)
            ->setOccurrence(new MultiDay(new Date($start), new Date($end)));

        $vCalendar = new Calendar([$vEvent]);

        $response = new Response(new CalendarFactory()->createCalendar($vCalendar)->__toString());
        $response->headers->set('Content-Type', 'text/calendar; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="cojob_nantes_ics_to_calendar.ics"');
        $response->prepare($request);

        return $response;
    }
}
