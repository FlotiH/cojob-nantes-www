<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SeoControllerTest extends WebTestCase
{
    public function testRobots(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/robots.txt');

        self::assertResponseIsSuccessful();
    }

    public function testSitemap(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plan-du-site');

        self::assertResponseIsSuccessful();
    }

    public function testSitemapXML(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sitemap.xml');

        self::assertResponseIsSuccessful();
    }
}
