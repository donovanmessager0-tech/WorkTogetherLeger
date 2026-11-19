<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Unite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unite::class);
    }

    /**
     * @return Unite[] Returns an array of Unite objects for the connected user
     */
    public function findByUser(Utilisateur $user): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.reservation', 'r') // Jointure directe entre Unite et Reservation
            ->andWhere('r.client = :user')    // Filtre sur le client de la réservation lié à l'utilisateur
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}