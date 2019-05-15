<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DraftRepository")
 */
class Draft
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $wallet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="drafts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="drafst")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWallet(): ?int
    {
        return $this->wallet;
    }

    public function setWallet(int $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getLeagueId(): ?League
    {
        return $this->league_id;
    }

    public function setLeagueId(?League $league_id): self
    {
        $this->league_id = $league_id;

        return $this;
    }
}
