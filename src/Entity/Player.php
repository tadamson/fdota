<?php

namespace App\Entity;

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
}
