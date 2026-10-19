<?php

namespace App\DataFixtures;

use App\Entity\Baie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BaieFixtures extends Fixture
{
    public const BAIE_REFERENCE_PREFIX = 'baie_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $baie = new Baie();
            $numeroBaie = sprintf('B%03d', $i); // Génère B001, B002, ..., B030
            $baie->setNumero($numeroBaie); // Adapte 'setNumero' selon le nom de ton champ dans l'entité Baie

            $manager->persist($baie);

            // On garde une référence si on veut l'utiliser dans d'autres fixtures
            $this->addReference(self::BAIE_REFERENCE_PREFIX . $i, $baie);
        }

        $manager->flush();
    }
}