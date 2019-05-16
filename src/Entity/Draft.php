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
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="drafts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DraftPick", mappedBy="draft_id")
     * @Assert\Count(
     *     max = 5,
     *     maxMessage = "Unable to draft more than {{limit}} picks"
     * )
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

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeagueId(?League $league): self
    {
        $this->league = $league;
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

    /**
     * @return bool
     */
    private function validCost(): bool
    {
        if (count($this->getPicks()) > 0) {
            $pick_total = 0;
            foreach ($this->getPicks() as $pick)
            {
                if ($pick->getCost() > 0)
                    $pick_total += $pick->getCost();
            }
            return ($pick_total > 0 && $pick_total <= $this->getWallet());
        }
        return true; // no picks made, might as well consider that valid
    }

    /**
     * @return bool
     */
    private function validPickCount(): bool
    {
        return !(count($this->getPicks()) > 5);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->validCost() && $this->validPickCount();
    }
}
