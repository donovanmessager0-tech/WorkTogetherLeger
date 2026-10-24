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
        $types = ['web', 'bdd', 'stockage'];
        $couleurs = ['bleu', 'vert', 'gris'];
        $statuts = ['OK', 'OK', 'OK', 'maintenance']; // Majoritairement OK

        // Boucle sur les 30 baies
        for ($b = 1; $b <= 30; $b++) {
            $numeroBaie = sprintf('B%03d', $b);
            $baie = $manager->getRepository(Baie::class)->findOneBy(['numero' => $numeroBaie]);

            if (!$baie) {
                continue;
            }

            // Boucle sur les 42 unités de chaque baie
            for ($u = 1; $u <= 42; $u++) {
                $unite = new Unite();
                
                // Format de l'emplacement ex: B014-U06
                $emplacement = sprintf('%s-U%02d', $numeroBaie, $u);

                
                $unite->setType($types[array_rand($types)]);
                $unite->setCouleur($couleurs[array_rand($couleurs)]);
                $unite->setStatut($statuts[array_rand($statuts)]); // Ou setEtat selon ton entité
                $unite->setNumeroU($u); // Décommente si tu as un champ spécifique pour le numéro d'unité

                $unite->setBaie($baie);

                // Optionnel : associer à une réservation de test si elle existe
                if ($reservation && $b === 1) { // On met les premières sur la réservation de test
                    $unite->setReservation($reservation);
                }

                $manager->persist($unite);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BaieFixtures::class,
            ReservationFixtures::class,
            UtilisateurFixtures::class,
            OffreFixtures::class,
        ];
    }
}