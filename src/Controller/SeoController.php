<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeoController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    private function getMap(): array
    {
        $events = $this->em
            ->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->getQuery()
            ->getResult();

        $eventsMap = [];
        /** @var Event $event */
        foreach ($events as $event) {
            $eventsMap[] = [
                'text' => $event->getName(),
                'url' => $this->generateUrl('event_show', ['slug' => $event->getSlug()])
            ];
        }

        return [
            [
                'text' => 'nav.homepage',
                'url' => $this->generateUrl('homepage'),
            ],
            [
                'text' => 'nav.support_us',
                'url' => $this->generateUrl('support'),
            ],
            [
                'text' => 'nav.guide',
                'url' => $this->generateUrl('guide'),
            ],
            [
                'text' => 'Mentions légales',
                'url' => $this->generateUrl('legals'),
            ],
            [
                'text' => 'nav.calendar',
                'url' => $this->generateUrl('calendar'),
            ],
            [
                'text' => 'nav.partners',
                'url' => $this->generateUrl('partners'),
            ],
            [
                'text' => 'Promos',
                'url' => $this->generateUrl('promos'),
            ],
            [
                'text' => 'Événements',
                'map' => $eventsMap
            ]
        ];
    }

    #[Route('/robots.txt', name: 'seo_robots')]
    public function robots(): Response
    {
        return $this->render('seo/robots.txt.twig');
    }

    #[Route('/plan-du-site', name: 'sitemap')]
    public function sitemap(): Response
    {
        $map = $this->getMap();
        return $this->render('seo/sitemap.html.twig', [
            'map' => $map
        ]);
    }

    #[Route('/sitemap.xml', name: 'seo_sitemap_google')]
    public function sitemapGoogle(): Response
    {
        $map = $this->getMap();
        return $this->render('seo/sitemap.xml.twig', [
            'map' => $map
        ]);
    }

}
