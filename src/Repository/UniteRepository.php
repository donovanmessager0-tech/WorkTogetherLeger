<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Unite;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unite>
 */
class UniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unite::class);
    }

//    /**
//     * @return Unite[] Returns an array of Unite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Unite
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/**
 * @return Unite[] Returns an array of Unite objects
 */
public function findOneByUser(Utilisateur $user): array
{
    return $this->createQueryBuilder('u')
        ->join('u.reservation', 'r') // Pointe vers le champ $reservation de Unite
        ->andWhere('r.client = :user')  // Pointe vers le champ $client de Reservation (qui est un Utilisateur)
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();
}
}


