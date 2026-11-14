<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }



    public function findByUser(Utilisateur $user): array
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.client = :user') 
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();
}
}
