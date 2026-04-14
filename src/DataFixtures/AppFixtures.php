<?php

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
        $contact = (new Contact())
            ->setLastName('lastname')
            ->setEmail('email@email.email')
            ->setFirstName('firstname')
            ->setMessage('message')
            ->setTelephone('0202020202');
        $manager->persist($contact);

        $article = (new Article())
            ->setImageLink('https://cojobnantes.fr/build/images/logo.d7e19af0.png')
            ->setTitle('title');
        $manager->persist($article);

        $event = (new Event())
            ->setName('name')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime())
            ->setMetaDescription('metadescription');
        $manager->persist($event);

        $media = new Media();
        $media->setImage('image');
        $manager->persist($media);

        $promo = (new Promo())
            ->setName('name')
            ->setStart(new \DateTime())
            ->setEnd(new \DateTime())
            ->setRegisteringStart(new \DateTime())
            ->setRegisteringEnd(new \DateTime());
        $manager->persist($promo);

        $testimony = (new Testimony())
            ->setName('name')
            ->setSubtitle('subtitle')
            ->setContent('content');
        $manager->persist($testimony);

        $user = (new User())
            ->setEmail('email@email.email')
            ->setPassword('pass');
        $manager->persist($user);

        $manager->flush();
    }
}
