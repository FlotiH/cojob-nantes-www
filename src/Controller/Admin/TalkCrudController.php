<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Talk;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @extends AbstractCrudController<Talk>
 */
class TalkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Talk::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::BATCH_DELETE, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setTemplatePath('admin/fields/vich_image.html.twig')
                ->setRequired(true),
            TextField::new('imageLink')
                ->onlyOnIndex()
                ->setTemplatePath('admin/fields/vich_image_link.html.twig'),
            TextField::new('title'),
            TextField::new('source'),
            DateField::new('date'),
            UrlField::new('link'),
            TextField::new('createdBy')->onlyOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
        ];
    }
}
