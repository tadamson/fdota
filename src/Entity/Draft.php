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
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="drafts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DraftPick", mappedBy="draft_id")
     * @Assert\Count(
     *     max = 5,
     *     maxMessage = "Unable to draft more than {{limit}} picks, currently have {{count}}."
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
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
     * @return int
     */
    private function currentPickCost(): int
    {
        $total = 0;
        foreach ($this->getPicks() as $pick)
        {
            $total += $pick->getCost();
        }
        return $total;
    }

    /**
     * @return bool
     */
    private function validCost(): bool
    {
        if (count($this->getPicks()) > 0) {
            $pick_total = $this->currentPickCost();
            return ($pick_total > 0 && $pick_total <= $this->getWallet());
        }
        return true; // no picks made, might as well consider that valid
    }

    /**
     * @return bool
     */
    private function validPickAmount(): bool
    {
        return !(count($this->getPicks()) > 5);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->validCost() && $this->validPickAmount();
    }

    /**
     * @return int
     */
    public function getWalletAvailable(): int
    {
        return ($this->getWallet() - $this->currentPickCost());
    }
}
