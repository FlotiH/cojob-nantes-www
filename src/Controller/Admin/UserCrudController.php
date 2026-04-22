<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SUPER_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_SUPER_ADMIN')
        ;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            BooleanField::new('enabled'),
            DateTimeField::new('lastLoginAt')
                ->hideOnForm(),
            TextField::new('plainPassword')
                ->hideOnIndex()
                ->setRequired(Crud::PAGE_NEW === $pageName),
        ];
    }

    public function encodePassword($user): void
    {
        if ($user instanceof User && $user->getPlainPassword()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $user->getPlainPassword())
            );
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }
}
