<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Media;
use App\Entity\Partner;
use App\Entity\Promo;
use App\Entity\Talk;
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
            ->setTitle('title')
            ->setButtonLabel('buttonLabel')
             ->setButtonLink('https://cojobnantes.fr/');
        $manager->persist($article);

        $event = new Event()
            ->setName('Apérotaf - Courses d\'obstacles de Cojob Nantes')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime('+ 2 hours'))
            ->setMetaDescription('metadescription');
        $manager->persist($event);

        $media = new Media();
        $media->setImage('image');
        $manager->persist($media);

        $promo = new Promo()
            ->setName('name')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime('+ 10 days'))
            ->setRegisteringStart(new \DateTime())
            ->setRegisteringEnd(new \DateTime());
        $manager->persist($promo);

        $testimony = new Testimony()
            ->setName('name')
            ->setSubtitle('subtitle')
            ->setContent('content')
            ->setFirstname('firstname')
            ->setAge(30)
            ->setPromoNb('promoNb');
        $manager->persist($testimony);

        $talk = new Talk()
            ->setTitle('title')
            ->setSource('source')
            ->setDate(new \DateTimeImmutable())
            ->setLink('https://cojobnantes.fr');
        $manager->persist($talk);

        $partner = new Partner()
            ->setPriority(1)
            ->setName('name')
        ;
        $manager->persist($partner);

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
