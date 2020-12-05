<?php

namespace App\Repository;

use App\Entity\Combinaison;
use App\Entity\Loto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Combinaison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Combinaison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Combinaison[]    findAll()
 * @method Combinaison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CombinaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Combinaison::class);
    }

    public function findCombinaisonsRestantes( Loto $loto )
    {
        return $this->createQueryBuilder('c')
            ->where('c.gagnant IS NULL')
            ->andWhere('c.loto = :loto')
            ->setParameter('loto', $loto)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Combinaison[] Returns an array of Combinaison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Combinaison
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
