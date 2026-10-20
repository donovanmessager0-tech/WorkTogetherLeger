<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rolesData = [
            ['Admin'],
            ['Accountant'],
            ['Client'],
            ['Technician'],
        ];
        foreach( $rolesData as $data) {
            $role = new role();
            $role->setNom($data[0]);
            $manager-> persist($role);
        }

        $manager->flush();
    }



}
