<?php

namespace App\Repository;

use App\Entity\Loto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Loto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loto[]    findAll()
 * @method Loto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loto::class);
    }

    // /**
    //  * @return Loto[] Returns an array of Loto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Loto
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
