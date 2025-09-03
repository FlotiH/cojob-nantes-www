<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        $publish = Action::new('publish', 'button.publish', 'fa fa-eye')
            ->linkToCrudAction('publish')
            ->setCssClass('text-success')
            ->displayIf(static function ($entity) {
                /* @var Article $entity */
                return !$entity->isPublished();
            });
        $unpublish = Action::new('unpublish', 'button.unpublish', 'fa fa-eye-slash')
            ->linkToCrudAction('unpublish')
            ->setCssClass('text-danger')
            ->displayIf(static function ($entity) {
                /* @var Article $entity */
                return $entity->isPublished();
            });

        $actions->add(Crud::PAGE_INDEX, $publish);
        $actions->add(Crud::PAGE_INDEX, $unpublish);

        return $actions
            ->disable(Action::BATCH_DELETE, Action::DETAIL, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('imageLink')
                ->setTemplatePath('admin/fields/image.html.twig'),
            TextField::new('title'),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            TextEditorField::new('content')->onlyOnForms(),
            DateTimeField::new('publishedAt'),
            DateTimeField::new('expiresAt'),
            TextField::new('createdBy')->onlyOnIndex(),
        ];
    }

    public function publish(AdminContext $context)
    {
        $article = $context->getEntity()->getInstance();

        $article->setPublished(true);
        $this->container->get('doctrine')->getManager()->flush();
        $this->addFlash('success', sprintf('Actualité "%s" publiée', $article));

        return $this->redirect($context->getReferrer());
    }

    public function unpublish(AdminContext $context)
    {
        $article = $context->getEntity()->getInstance();

        $article->setPublished(false);
        $this->container->get('doctrine')->getManager()->flush();
        $this->addFlash('success', sprintf('Actualité "%s" dépubliée', $article));

        return $this->redirect($context->getReferrer());
    }
}
