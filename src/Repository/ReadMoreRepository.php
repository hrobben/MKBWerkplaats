<?php

namespace App\Repository;

use App\Entity\ReadMore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReadMore|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReadMore|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReadMore[]    findAll()
 * @method ReadMore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReadMoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReadMore::class);
    }

    // /**
    //  * @return ReadMore[] Returns an array of ReadMore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReadMore
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
