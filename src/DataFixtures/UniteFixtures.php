<?php

namespace App\DataFixtures;

use App\Entity\Unite;
use App\Entity\Baie;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UniteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reservation = $manager->getRepository(Reservation::class)->findOneBy([]);
        for ($i = 1; $i <= 5; $i++) {
        $unite = new Unite();
        $unite->setNom('Serveur Test ' . $i);
        $unite->setType($i % 2 === 0 ? 'web' : 'bdd');
        $unite->setCouleur($i % 2 === 0 ? 'bleu' : 'vert');
        $unite->setEmplacement('B014-U0' . $i);
        $unite->setEtat('OK');
        
        if ($reservation) {
            $unite->setReservation($reservation);
        }

        $manager->persist($unite);
    }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OffreFixtures::class,
            ReservationFixtures::class,
        ];
    }
    }

