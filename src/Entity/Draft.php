<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DraftPick", mappedBy="draft_id")
     */
    private $picks;

    public function __construct()
    {
        $this->picks = new ArrayCollection();
    }

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

    /**
     * @return Collection|DraftPick[]
     */
    public function getPicks(): Collection
    {
        return $this->picks;
    }

    public function addPick(DraftPick $pick): self
    {
        if (!$this->picks->contains($pick)) {
            $this->picks[] = $pick;
            $pick->setDraft($this);
        }

        return $this;
    }

    public function removePick(DraftPick $pick): self
    {
        if ($this->picks->contains($pick)) {
            $this->picks->removeElement($pick);
            // set the owning side to null (unless already changed)
            if ($pick->getDraft() === $this) {
                $pick->setDraft(null);
            }
        }

        return $this;
    }
}
