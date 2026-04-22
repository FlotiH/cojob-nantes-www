<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Media;
use App\Entity\Promo;
use App\Entity\Testimony;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = new Contact()
            ->setLastName('lastname')
            ->setEmail('email@email.email')
            ->setFirstName('firstname')
            ->setMessage('message')
            ->setTelephone('0202020202');
        $manager->persist($contact);

        $article = new Article()
            ->setImageLink('https://cojobnantes.fr/build/images/logo.d7e19af0.png')
            ->setTitle('title');
        $manager->persist($article);

        $event = new Event()
            ->setName('Apérotaf - Courses d\'obstacles de Cojob Nantes')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime())
            ->setMetaDescription('metadescription');
        $manager->persist($event);

        $media = new Media();
        $media->setImage('image');
        $manager->persist($media);

        $promo = new Promo()
            ->setName('name')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime())
            ->setRegisteringStart(new \DateTime())
            ->setRegisteringEnd(new \DateTime());
        $manager->persist($promo);

        $testimony = new Testimony()
            ->setName('name')
            ->setSubtitle('subtitle')
            ->setContent('content');
        $manager->persist($testimony);

        $user = new User()
            ->setEmail('email@email.email')
            ->setPassword('$2y$13$KzXFPUZnVmFdU5Y0V6vSbuF8Lk/fKoR/MK2JpwKL9iVI77AXK9Hqe')
            ->setRoles(['ROLE_WEBMASTER']);
        $admin = new User()
            ->setEmail('admin@email.email')
            ->setPassword('$2y$13$KzXFPUZnVmFdU5Y0V6vSbuF8Lk/fKoR/MK2JpwKL9iVI77AXK9Hqe')
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);
        $manager->persist($admin);

        $manager->flush();
    }
}
