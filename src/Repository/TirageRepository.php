<?php

namespace App\Repository;

use App\Entity\Loto;
use App\Entity\Tirage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tirage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tirage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tirage[]    findAll()
 * @method Tirage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TirageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tirage::class);
    }

    public function randomTirage( int $lotoId )
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t
            FROM App\Entity\Tirage t
            WHERE t.dateTirage IS NULL
            and t.loto = :loto
            order by rand() ASC'
        )->setParameter('loto', $lotoId);

        $query->setMaxResults(1);

        return $query->getResult();
    }

    public function findNombreTires( Loto $loto )
    {
        return $this->createQueryBuilder('t')
            //->select('t.nombre')
            ->where('t.dateTirage IS NOT NULL')
            ->andWhere('t.loto = :loto')
            ->setParameter('loto', $loto)
            ->orderBy('t.ordre', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    public function nombreDuJour( \DateTime $debut, \DateTime $fin, Loto $loto )
    {
        return $this->createQueryBuilder('t')
            ->where('t.dateTirage >= :debut')
            ->andWhere('t.dateTirage <= :fin')
            ->andWhere('t.loto = :loto')
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('loto', $loto)
            ->orderBy('t.ordre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Tirage[] Returns an array of Tirage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tirage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
