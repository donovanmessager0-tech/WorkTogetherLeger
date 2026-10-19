<?php

namespace App\DataFixtures;

use App\Entity\Baie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BaieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 30; $i++) {
            $baie = new Baie();
            

            $numeroBaie = sprintf('B%03d', $i);
            $baie->setNumero($numeroBaie); 

            $manager->persist($baie);
        }
        $manager->flush();
    }
}
