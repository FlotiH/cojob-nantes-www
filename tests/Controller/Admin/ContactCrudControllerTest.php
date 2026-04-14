<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ContactCrudController;
use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

final class ContactCrudControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return ContactCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    // not logged
    public function testIndexPageNotlogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/login', 302);
    }

    public function testNewPageNotlogged(): void
    {
        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/login', 302);
    }

    public function testEditPageNotlogged(): void
    {
        $this->client->request('GET', $this->generateEditFormUrl(1618));
        static::assertResponseRedirects('/login', 302);
    }

    public function testDetailPageNotlogged(): void
    {
        $this->client->request('GET', $this->generateDetailUrl(1618));
        static::assertResponseRedirects('/login', 302);
    }

    // logged
    public function testIndexPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();
    }

    public function testNewPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    // TODO FHA : comment trouver l'id ?
    public function testEditPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateEditFormUrl(1618));
        static::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDetailPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateDetailUrl(1618));
        static::assertResponseIsSuccessful();
    }
}
