<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
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
        ];
    }
}
