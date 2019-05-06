<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * from dota2 api
     */
    private $dota_match_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", inversedBy="matches")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MatchPlayer")
     */
    private $players;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDotaMatchId()
    {
        return $this->dota_match_id;
    }

    /**
     * @param mixed $dota_match_id
     */
    public function setDotaMatchId($dota_match_id): void
    {
        $this->dota_match_id = $dota_match_id;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    /**
     * @return Collection|MatchPlayer[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(MatchPlayer $player): self
    {
        if (!$this->players->contains($player) && count($this->players) < 10 ) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer(MatchPlayer $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
        }

        return $this;
    }
}
