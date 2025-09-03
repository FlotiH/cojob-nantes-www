<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Media;
use App\Entity\Promo;
use App\Entity\Testimony;
use App\Entity\User;
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
        yield MenuItem::linkToCrud('Contact', 'fas fa-address-card', Contact::class);
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        }
        yield MenuItem::linkToCrud('Article', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Event', 'fas fa-calendar-check', Event::class);
        yield MenuItem::linkToCrud('Testimony', 'fas fa-comments', Testimony::class);
        yield MenuItem::linkToCrud('Promo', 'fas fa-users', Promo::class);
        yield MenuItem::linkToCrud('Media', 'fas fa-photo-video', Media::class);
        yield MenuItem::linkToLogout('security.logout', 'fa fa-fw fa-sign-out');
    }
}