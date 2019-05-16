<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @ORM\Table("players")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * via Steam/Dota2 API
     */
    private $steam_id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $team_role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bio_link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="Players")
     */
    private $team;

    /**
     * @ORM\Column(type="integer")
     *
     * based on recent/past fantasy point ratings
     */
    private $draft_cost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerStats", mappedBy="player", orphanRemoval=true)
     */
    private $playerStats;

    public function __construct()
    {
        $this->playerStats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSteamId(): ?int
    {
        return $this->steam_id;
    }

    public function setSteamId(?int $SteamId): self
    {
        $this->steam_id = $SteamId;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTeamRole(): ?int
    {
        return $this->team_role;
    }

    public function setTeamRole(int $team_role): self
    {
        $this->team_role = $team_role;
        return $this;
    }

    public function getBioLink(): ?string
    {
        return $this->bio_link;
    }

    public function setBioLink(?string $bio_link): self
    {
        $this->bio_link = $bio_link;
        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;
        return $this;
    }

    public function getDraftCost(): ?int
    {
        return $this->draft_cost;
    }

    public function setDraftCost(int $draft_cost): self
    {
        $this->draft_cost = $draft_cost;
        return $this;
    }

    /**
     * @return Collection|PlayerStats[]
     */
    public function getPlayerStats(): Collection
    {
        return $this->playerStats;
    }

    public function addPlayerStat(PlayerStats $playerStat): self
    {
        if (!$this->playerStats->contains($playerStat)) {
            $this->playerStats[] = $playerStat;
            $playerStat->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerStat(PlayerStats $playerStat): self
    {
        if ($this->playerStats->contains($playerStat)) {
            $this->playerStats->removeElement($playerStat);
            // set the owning side to null (unless already changed)
            if ($playerStat->getPlayer() === $this) {
                $playerStat->setPlayer(null);
            }
        }

        return $this;
    }
}
