<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public const RESERVATION_REFERENCE_PREFIX = 'reservation_';

    public function load(ObjectManager $manager): void
    {
        // [Référence de l'utilisateur, Nom de l'offre voulue]
        $reservationsData = [
            ['user_1', 'Base'],       // 1ère réservation pour l'utilisateur 1
            ['user_1', 'Start-up'],   // 2ème réservation pour l'utilisateur 1
            ['user_2', 'PME'],        // 1ère réservation pour l'utilisateur 2
        ];

        foreach ($reservationsData as $index => $data) {
            $userReference = $data[0];
            $offreNom = $data[1];

            $user = $this->getReference($userReference, Utilisateur::class);
            // On va chercher l'offre correspondante en base de données
            $client= $this->getReference('client_' . ($index + 1), Client::class);
            $offre = $manager->getRepository(Offre::class)->findOneBy(['nom' => $offreNom]);

            if ($user && $offre) {
                $reservation = new Reservation();
                $reservation->setClient($user);
                $reservation->setOffre($offre);

                $manager->persist($reservation);

                // Optionnel : crée des références reservation_1, reservation_2, reservation_3
                $this->addReference(self::RESERVATION_REFERENCE_PREFIX . ($index + 1), $reservation);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            OffreFixtures::class,
        ];
    }
}