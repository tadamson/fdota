<?php

namespace App\Repository;

use App\Entity\DraftPick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DraftPick|null find($id, $lockMode = null, $lockVersion = null)
 * @method DraftPick|null findOneBy(array $criteria, array $orderBy = null)
 * @method DraftPick[]    findAll()
 * @method DraftPick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DraftPickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DraftPick::class);
    }

    // /**
    //  * @return DraftPick[] Returns an array of DraftPick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DraftPick
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
