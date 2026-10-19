<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Utilisateur3Fixtures extends Fixture
{
    public const USER_REFERENCE = 'user_3'; 

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Utilisateur();
        $user->setEmail('machin.truc@worktogether.com'); 
        $user->setNom('Truc');                       
        $user->setPrenom('Machin');                    
        $user->setIdentifiant('Mtruc');               
        $user->setSociety('holy randomness');              
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'MyParentsWereSoOriginalsfrfr');
        $user->setMdp($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        // Enregistre la référence correspondante
        $this->addReference(self::USER_REFERENCE, $user);
    }
}