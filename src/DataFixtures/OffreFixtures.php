<?php

namespace App\DataFixtures;

use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OffreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
$offresData = [
            ['Base', 100.00, 1080.00, 1],
            ['Start-up', 900.00, 9720.00, 10],
            ['PME', 1680.00, 18144.00, 21],
            ['Entreprise', 2940.00, 31752.00, 42],
        ];
        foreach( $offresData as $data) {
            $offre = new Offre();
            $offre->setNom($data[0]);
            $offre->setPrixMensuel($data[1]);
            $offre->setPrixAnnuel($data[2]);
            $offre->setNbunit($data[3]);
            $manager-> persist($offre);
        }

        $manager->flush();
    }
}
