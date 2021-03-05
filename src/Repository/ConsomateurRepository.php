<?php

namespace App\Repository;

use App\Entity\Consomateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consomateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consomateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consomateur[]    findAll()
 * @method Consomateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsomateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consomateur::class);
    }

    // /**
    //  * @return Consomateur[] Returns an array of Consomateur objects
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
    public function findOneBySomeField($value): ?Consomateur
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
