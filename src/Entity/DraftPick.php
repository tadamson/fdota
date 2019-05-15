<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DraftPickRepository")
 */
class DraftPick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Draft", inversedBy="picks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $draft_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDraftId(): ?Draft
    {
        return $this->draft_id;
    }

    public function setDraftId(?Draft $draft_id): self
    {
        $this->draft_id = $draft_id;

        return $this;
    }

    public function getPlayerId(): ?Player
    {
        return $this->player_id;
    }

    public function setPlayerId(?Player $player_id): self
    {
        $this->player_id = $player_id;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
