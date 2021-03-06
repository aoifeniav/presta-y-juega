<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Game[]    findAllByOwnerDifferentThan(int $id)
 * @method Game[]    findAllByOwner(int $id)
 * @method Game[]    findAllBySearch(?string $query)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findAllByOwner($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT g FROM App:Game g WHERE g.owner = ' . $id
            )
            ->getResult();
    }

    public function findAllByOwnerDifferentThan($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT g FROM App:Game g WHERE g.owner <> ' . $id
            )
            ->getResult();
    }

    public function findAllBySearch(string $query)
    {
        $qb = $this->createQueryBuilder('g');
        if ($query) {
            $qb->andWhere('g.name LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
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
    public function findOneBySomeField($value): ?Game
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
