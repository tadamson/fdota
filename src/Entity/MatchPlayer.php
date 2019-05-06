<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchPlayerRepository")
 */
class MatchPlayer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="float")
     */
    private $fantasy_points;

    /**
     * @ORM\Column(type="boolean")
     *
     * 0 = radiant, 1 = dire
     * or scourge/sentinel, red/blue, whatever/whocares
     */
    private $map_side;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     *
     * in-game position played, 1-5
     */
    private $role;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Hero", cascade={"persist", "remove"})
     */
    private $hero_played;

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

    public function getMapSide(): ?bool
    {
        return $this->map_side;
    }

    public function setMapSide(bool $map_side): self
    {
        $this->map_side = $map_side;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(?int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getHeroPlayed(): ?Hero
    {
        return $this->hero_played;
    }

    public function setHeroPlayed(?Hero $hero_played): self
    {
        $this->hero_played = $hero_played;
        return $this;
    }
}
