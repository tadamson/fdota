<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\PlayerStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerStats[]    findAll()
 * @method PlayerStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerStatsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerStats::class);
    }

    public function findByPlayer(Player $player, int $limit = 25, ?\DateTimeInterface $since = null)
    {
        $q = $this->createQueryBuilder('p')
            ->andWhere('p.player = :id')
            ->setParameter('id', $player->getId());
        if ($since != null)
        {
            $q->andWhere('p.date_recorded >= :since')
                ->setParameter('since', $since);
        }
        if ($limit > 0)
        {
            $q->setMaxResults($limit);
        }
        return $q->getQuery()->getResult();
    }

    /**
     * @param \DateTimeInterface|null $since
     * @throws \Exception
     *
     * update historical stats from match data. make sure match data is updated first
     * & keep this cron'd to a static interval
     *
     * TODO: make sure this works
     */
    public function updateStatsForInterval(?\DateTimeInterface $since = null)
    {
        if ($since == null)
        {
            $since = $this->createQueryBuilder('s')
                ->select('MAX(s.date_recorded) AS latest')
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
            if (!$since) $since = new \DateTime('now');
        }

        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = <<<EOSQL
INSERT INTO player_stats (player_id, date_recorded, fantasy_points, matcn_count)
SELECT player_id, NOW() as date_recorded, SUM(fantasy_points), COUNT(*) AS match_count
FROM match_players
WHERE date_played >= :since
GROUP BY player_id
EOSQL;
            $stmt = $conn->prepare($sql);
            $stmt->execute(['since' => $since]);
        } catch (DBALException $e) {
            // TODO: implement some logging
        }
    }
}
