<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Reservation1Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager$manager): void
    {
        $user = $this->getReference(Utilisateur1Fixtures::USER_REFERENCE, Utilisateur::class);
        
        $offre = $manager->getRepository(Offre::class)->findOneBy(['nom' => 'Base']);

        if ($user && $offre) {
            $reservation = new Reservation();
            $reservation->setUtilisateur($user);
            $reservation->setOffre($offre);

            $manager->persist($reservation);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            Utilisateur1Fixtures::class, 
            OffreFixtures::class,
        ];
    }
}

class Reservation2Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager$manager): void
    {
        $user = $this->getReference(Utilisateur2Fixtures::USER_REFERENCE, Utilisateur::class);
        
        $offre = $manager->getRepository(Offre::class)->findOneBy(['nom' => 'Entreprise']);

        if ($user && $offre) {
            $reservation = new Reservation();
            $reservation->setUtilisateur($user);
            $reservation->setOffre($offre);

            $manager->persist($reservation);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            Utilisateur2Fixtures::class, 
            OffreFixtures::class,
        ];
    }
}

class Reservation3Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager$manager): void
    {
        $user = $this->getReference(Utilisateur2Fixtures::USER_REFERENCE, Utilisateur::class);
        
        $offre = $manager->getRepository(Offre::class)->findOneBy(['nom' => 'PME']);

        if ($user && $offre) {
            $reservation = new Reservation();
            $reservation->setUtilisateur($user);
            $reservation->setOffre($offre);

            $manager->persist($reservation);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            Utilisateur2Fixtures::class, 
            OffreFixtures::class,
        ];
    }
}