<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\PromoCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

final class PromoCrudControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return PromoCrudController::class;
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
        $this->client->request('GET', $this->generateEditFormUrl(1));
        static::assertResponseRedirects('/login', 302);
    }

    public function testDetailPageNotlogged(): void
    {
        $this->client->request('GET', $this->generateDetailUrl(1));
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
        static::assertResponseIsSuccessful();
    }

    public function testEditPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateEditFormUrl(1));
        static::assertResponseIsSuccessful();
    }

    public function testDetailPage(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}
