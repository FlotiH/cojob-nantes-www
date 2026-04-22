<?php

namespace App\EventSubscriber;

use App\Entity\Promo;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly UrlGeneratorInterface $router)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        //        $filters = $calendar->getFilters();

        $promos = $this->em->getRepository(Promo::class)
            ->createQueryBuilder('p')
            ->where('p.start BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        /** @var Promo $promo */
        foreach ($promos as $promo) {
            $promoStart = $promo->getStart();
            $nextSaturday = clone $promoStart;
            $nextSaturday = $nextSaturday->modify('next saturday');
            while ($nextSaturday < $promo->getEnd()) {
                $calendar->addEvent(new Event(
                    $promo->getName(),
                    clone $promoStart,
                    clone $nextSaturday
                ));

                $nextMonday = clone $promoStart;
                $promoStart = $nextMonday->modify('next monday');
                $nextSaturday = $nextSaturday->modify('next saturday');
            }

            $calendar->addEvent(new Event(
                $promo->getName(),
                clone $promoStart,
                clone ($promo->getEnd())->setTime(23, 59)
            ));
        }

        // Get events
        $events = $this->em->getRepository(\App\Entity\Event::class)
            ->createQueryBuilder('e')
            ->where('e.start BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        /** @var Event $event */
        foreach ($events as $event) {
            $bookingEvent = new Event(
                $event->getName(),
                $event->getStart(),
                $event->getEnd()
            );

            $bookingEvent->setOptions([
                'backgroundColor' => '#0e3d67',
                'borderColor' => '#0e3d67',
            ]);

            $bookingEvent->addOption(
                'url',
                $this->router->generate('event_show', [
                    'slug' => $event->getSlug(),
                ])
            );

            $calendar->addEvent($bookingEvent);
        }
    }
}
