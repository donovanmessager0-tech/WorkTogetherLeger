<?php 

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\Unite;
use Doctrine\ORM\EntityManagerInterface;

class UniteManager{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }

    public function getUnitesForUser (Utilisateur $user): array {
        $unites = $this->entityManager->getRepository(Unite::class)->createQueryBuilder('u')
            ->join('u.reservation', 'r')
            ->andWhere('r.client = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    
    return $unites;
}
}