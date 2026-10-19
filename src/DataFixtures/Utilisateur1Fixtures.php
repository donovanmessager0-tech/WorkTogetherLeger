<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Utilisateur1Fixtures extends Fixture
{
    // Change le nom de la référence pour chaque utilisateur (ex: 'user_1', 'user_2'...)
    public const USER_REFERENCE = 'user_1'; 

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Utilisateur();
        $user->setEmail('jean.dupont@worktogether.com'); // Adapte l'email
        $user->setNom('Dupont');                       // Adapte le nom
        $user->setPrenom('Jean');                      // Adapte le prénom
        $user->setIdentifiant('jdupont');                // Adapte l'identifiant
        $user->setSociety('Data Corp');                // Adapte la société
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
        $user->setMdp($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        // Enregistre la référence correspondante
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
