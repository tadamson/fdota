<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerStatsRepository")
 */
class PlayerStats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playerStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="float")
     */
    private $fantasy_points;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $date_recorded;

    /**
     * @ORM\Column(type="integer")
     */
    private $match_count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getFantasyPoints(): ?float
    {
        return $this->fantasy_points;
    }

    public function setFantasyPoints(float $fantasy_points): self
    {
        $this->fantasy_points = $fantasy_points;

        return $this;
    }

    public function getDateRecorded(): ?\DateTimeInterface
    {
        return $this->date_recorded;
    }

    public function setDateRecorded(\DateTimeInterface $date_recorded): self
    {
        $this->date_recorded = $date_recorded;

        return $this;
    }

    public function getMatchCount(): ?int
    {
        return $this->match_count;
    }

    public function setMatchCount(int $match_count): self
    {
        $this->match_count = $match_count;

        return $this;
    }
}
