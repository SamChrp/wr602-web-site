<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subscription1 = new Subscription();
        $subscription1->setTitle('Basique');
        $subscription1->setPrice(0);
        $subscription1->setDescription('L\'Abonnement basique est gratuit. Il vous permet de profiter de 2 convertions de PDf par jour.');
        $subscription1->setPfdLimit(2);
        $manager->persist($subscription1);

        $subscription2 = new Subscription();
        $subscription2->setTitle('Premium');
        $subscription2->setPrice(9.99);
        $subscription2->setDescription('L\'Abonnement premium revient à 9,99€/mois. Il vous permet de profiter de 10 convertions de PDf par jour.');
        $subscription2->setPfdLimit(10);
        $manager->persist($subscription2);

        $subscription3 = new Subscription();
        $subscription3->setTitle('Illimité');
        $subscription3->setPrice(24.99);
        $subscription3->setDescription('L\'Abonnement illimité revient à 24,99€/mois. Il vous permet de profiter d\'un nombre illimité de convertions de PDf par jour.');
        $subscription3->setPfdLimit(-1);
        $manager->persist($subscription3);

        $manager->flush();
    }
}
