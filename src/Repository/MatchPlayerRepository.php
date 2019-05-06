<?php

namespace App\Repository;

use App\Entity\MatchPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MatchPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchPlayer[]    findAll()
 * @method MatchPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchPlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MatchPlayer::class);
    }

    // /**
    //  * @return MatchPlayer[] Returns an array of MatchPlayer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MatchPlayer
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
