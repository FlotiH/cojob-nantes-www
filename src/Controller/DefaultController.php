<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Promo;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\PromoRepository;
use App\Repository\TestimonyRepository;
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
    public function indexAction(ArticleRepository $articleRepo, PromoRepository $promoRepo, TestimonyRepository $testimonyRepo): RedirectResponse|Response
    {
        $requiredPromoTestimonies = $testimonyRepo->findRequiredPromoTestimonies();

        $nbRequiredTestmonies = \count($requiredPromoTestimonies);

        if ($nbRequiredTestmonies < 6) {
            $promoTestimonies = $testimonyRepo->findNotRequiredPromoTestimonies($nbRequiredTestmonies);
        } else {
            $promoTestimonies = [];
        }

        return $this->render('default/index.html.twig', [
            'articles' => $articleRepo->findPublishedArticles(),
            'requiredPromoTestimonies' => $requiredPromoTestimonies,
            'promoTestimonies' => $promoTestimonies,
            'promoOpen' => $promoRepo->findOpenPromos(),
        ]);
    }

    #[Route('/promos', name: 'promos')]
    public function promosAction(PromoRepository $promoRepo): Response
    {
        return $this->render('default/promos.html.twig', [
            'promos' => $promoRepo->findAvailablePromos(),
            'otherPromos' => $promoRepo->findNotAvailablePromos(),
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
