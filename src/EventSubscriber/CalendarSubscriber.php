<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Event as EntityEvent;
use App\Entity\Promo;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;
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
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent): void
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();

        /** @var Promo[] $promos */
        $promos = $this->em->getRepository(Promo::class)
            ->createQueryBuilder('p')
            ->where('p.start BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($promos as $promo) {
            $promoStart = $promo->getStart();
            $nextSaturday = clone $promoStart;
            $nextSaturday = $nextSaturday->modify('next saturday');
            while ($nextSaturday < $promo->getEnd()) {
                $setDataEvent->addEvent(new Event(
                    $promo->getName(),
                    clone $promoStart,
                    clone $nextSaturday
                ));

                $nextMonday = clone $promoStart;
                $promoStart = $nextMonday->modify('next monday');
                $nextSaturday = $nextSaturday->modify('next saturday');
            }

            $setDataEvent->addEvent(new Event(
                $promo->getName(),
                clone $promoStart,
                (clone $promo->getEnd())->setTime(23, 59)
            ));
        }

        // Get events
        /** @var EntityEvent[] $events */
        $events = $this->em->getRepository(EntityEvent::class)
            ->createQueryBuilder('e')
            ->where('e.start BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

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

            $setDataEvent->addEvent($bookingEvent);
        }
    }
}
