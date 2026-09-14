<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @extends AbstractCrudController<Partner>
 */
class PartnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['priority' => 'ASC']);
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
                ->setHelp('help.image.max170x64')
                ->setFormType(VichImageType::class)
                ->setTemplatePath('admin/fields/vich_image.html.twig')
                ->setRequired(Crud::PAGE_NEW === $pageName),
            TextField::new('name'),
            UrlField::new('link')
                ->setFormTypeOption('attr.placeholder', 'placeholder.website'),
            IntegerField::new('priority'),
            TextField::new('createdBy')->onlyOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
        ];
    }
}
