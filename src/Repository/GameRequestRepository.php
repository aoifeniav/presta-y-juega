<?php

namespace App\Repository;

use App\Entity\GameRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameRequest[]    findAll()
 * @method GameRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameRequest::class);
    }

    // /**
    //  * @return GameRequest[] Returns an array of GameRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameRequest
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
