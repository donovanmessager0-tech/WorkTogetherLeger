<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    public const USER_REFERENCE_PREFIX = 'user_';
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            // [Email, Nom, Prénom, Identifiant, Société, Mot de passe]
            ['jean.dupont@worktogether.com', 'Dupont', 'Jean', 'jdupont', 'Data Corp', 'password123'],
            ['jeanne.duchemin@worktogether.com', 'Duchemin', 'Jeanne', 'jduchemin', 'WorkuhTogetheranh', 'thisisnotsecure'],
            ['machin.truc@worktogether.com', 'Truc', 'Machin', 'Mtruc', 'holy randomness', 'MyParentsWereSoOriginalsfrfr'],
        ];

        $roleClient = $manager->getRepository(Role::class)->findOneBy(['nom' => 'Client']);

        foreach ($usersData as $index => $data) {
            $user = new Utilisateur();
            $user->setEmail($data[0]);
            $user->setNom($data[1]);
            $user->setPrenom($data[2]);
            $user->setIdentifiant($data[3]);
            $user->setSociety($data[4]);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data[5]);
            $user->setMdp($hashedPassword);

            if ($roleClient) {
            $user->addRole($roleClient); 
    }
            $manager->persist($user);

            // Crée dynamiquement les références : user_1, user_2, user_3
            $this->addReference(self::USER_REFERENCE_PREFIX . ($index + 1), $user);
        }

        $manager->flush();
    }
}