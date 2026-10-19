<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class Utilisateur2Fixtures extends Fixture
{
    // Change le nom de la référence pour chaque utilisateur (ex: 'user_1', 'user_2'...)
    public const USER_REFERENCE = 'user_2'; 

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Utilisateur();
        $user->setEmail('jeanne.duchemin@worktogether.com'); 
        $user->setNom('Duchemin');                
        $user->setPrenom('Jeanne');                     
        $user->setIdentifiant('jduchemin');                
        $user->setSociety('WorkuhTogetheranh');                
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'thisisnotsecure');
        $user->setMdp($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        // Enregistre la référence correspondante
        $this->addReference(self::USER_REFERENCE, $user);
    }
}

