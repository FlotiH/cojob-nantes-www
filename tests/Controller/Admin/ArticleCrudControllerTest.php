<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ArticleCrudController;
use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

final class ArticleCrudControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return ArticleCrudController::class;
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

    public function testPublishActionNotlogged(): void
    {
        $this->client->request('GET', $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->setAction('publish')
            ->setEntityId(1)
            ->generateUrl());
        static::assertResponseRedirects('/login', 302);
    }

    public function testUnpublishActionNotlogged(): void
    {
        $this->client->request('GET', $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->setAction('unpublish')
            ->setEntityId(1)
            ->generateUrl());
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

    public function testPublishAction(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->setAction('publish')
            ->setEntityId(1)
            ->generateUrl());
        static::assertResponseRedirects('/admin/article');
    }

    public function testUnpublishAction(): void
    {
        $testUser = new InMemoryUser('user', 'pass', ['ROLE_WEBMASTER']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->setAction('unpublish')
            ->setEntityId(1)
            ->generateUrl());
        static::assertResponseRedirects('/admin/article');
    }
}
