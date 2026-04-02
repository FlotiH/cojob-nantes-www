<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ContactCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="static/images/logo.png" alt="Cojob Nantes" style="max-width: 100%">')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkTo(ContactCrudController::class, 'Contact', 'fas fa-address-card');
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::linkTo(UserCrudController::class, 'User', 'fas fa-user');
        }
        yield MenuItem::linkTo(ArticleCrudController::class, 'Article', 'fas fa-newspaper');
        yield MenuItem::linkTo(EventCrudController::class, 'Event', 'fas fa-calendar-check');
        yield MenuItem::linkTo(TestimonyCrudController::class, 'Testimony', 'fas fa-comments');
        yield MenuItem::linkTo(PromoCrudController::class, 'Promo', 'fas fa-users');
        yield MenuItem::linkTo(MediaCrudController::class, 'Media', 'fas fa-photo-video');
        yield MenuItem::linkToLogout('security.logout', 'fa fa-fw fa-sign-out');
    }
}
