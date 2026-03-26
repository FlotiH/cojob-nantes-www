<?php

namespace App\Tests\Controller;

use App\Entity\Event;
use App\Entity\Promo;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PromoRepository $promoRepository;
    private EntityRepository $eventRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->promoRepository = static::getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Promo::class);
        $this->eventRepository = static::getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Event::class);
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Cojob Nantes : la recherche d\'emploi collective');
    }

    public function testPromo(): void
    {
        $crawler = $this->client->request('GET', '/promos');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Les promos de Cojob Nantes');
    }

    public function testSupport(): void
    {
        $crawler = $this->client->request('GET', '/nous-soutenir');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Nous soutenir');
    }

    public function testLegals(): void
    {
        $crawler = $this->client->request('GET', '/mentions-legales');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Mentions légales');
    }

    public function testCalendar(): void
    {
        $crawler = $this->client->request('GET', '/calendrier');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Calendrier');
    }

    public function testGuide(): void
    {
        $crawler = $this->client->request('GET', '/l-explorateur-guide-de-l-emploi');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'L\'explorateur : le guide de l\'emploi à usage des aventuriers nantais');
    }

    public function testEventShow(): void
    {
        $event = $this->eventRepository->find(1);
        $crawler = $this->client->request('GET', '/evenement/'.$event->getSlug());

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Apérotaf - Courses d\'obstacles de Cojob Nantes');
    }

    public function testPromoGetICal(): void
    {
        $promo = $this->promoRepository->find(1);
        $crawler = $this->client->request('GET', '/promo/'.$promo->getId().'/get-ical');

        self::assertResponseIsSuccessful();
    }

    public function testPromoRegistrationGetICal(): void
    {
        $promo = $this->promoRepository->find(1);
        $crawler = $this->client->request('GET', '/promo/registration/'.$promo->getId().'/get-ical');

        self::assertResponseIsSuccessful();
    }

    public function testContact(): void
    {
        $crawler = $this->client->request('GET', '/contact');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Contact');
    }

    public function testPartners(): void
    {
        $crawler = $this->client->request('GET', '/partenaires');

        self::assertResponseIsSuccessful();
    }

    public function testContactHoneypot(): void
    {
        $crawler = $this->client->request('GET', '/contact');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('Envoyer', [
            'app_contact[last_name]' => 'test',
            'app_contact[first_name]' => 'test',
            'app_contact[email]' => 'test@test.test',
            'app_contact[telephone]' => 'test',
            'app_contact[message]' => 'test',
            'app_contact[name]' => 'honeypot',
        ]);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        self::assertSelectorTextContains('.alert-danger', 'SPAM detecté, demande non envoyée');
    }
}
