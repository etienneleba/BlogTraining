<?php

namespace App\Repository;

use App\Entity\Alternative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method null|Alternative find($id, $lockMode = null, $lockVersion = null)
 * @method null|Alternative findOneBy(array $criteria, array $orderBy = null)
 * @method Alternative[]    findAll()
 * @method Alternative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlternativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alternative::class);
    }

    public function findAll()
    {
        return  $this->findBy([], ['created_at' => 'DESC']);
    }

    // /**
    //  * @return Alternative[] Returns an array of Alternative objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alternative
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
