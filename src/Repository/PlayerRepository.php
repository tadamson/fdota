<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @param int $pos
     * @return array
     */
    public function findAllByPosition(int $pos = 1)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.team_role = :pos')
            ->setParameter('pos', $pos)
            ->orderBy('p.name')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param int $cost
     * @return array
     */
    public function findAllUnderCost(int $cost)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.draft_cost < :cost')
            ->setParameter('cost', $cost)
            ->orderBy('p.draft_cost', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
