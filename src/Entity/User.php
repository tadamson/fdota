<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knojector\SteamAuthenticationBundle\User\AbstractSteamUser;
use Doctrine\ORM\Mapping as ORM;

class user extends AbstractSteamUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotNull()
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotNull()
     */
    private $last_seen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Draft", mappedBy="user_id")
     */
    private $drafts;

    public function __construct()
    {
        $this->drafts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active)
    {
        $this->active = $active;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(?\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;
    }

    public function getLastSeen(): ?\DateTimeInterface
    {
        return $this->last_seen;
    }

    public function setLastSeen(?\DateTimeInterface $last_seen): self
    {
        $this->last_seen = $last_seen;
    }

    /**
     * @return Collection|Draft[]
     */
    public function getDrafts(): Collection
    {
        return $this->drafts;
    }

    public function addDraft(Draft $draft): self
    {
        if (!$this->drafts->contains($draft)) {
            $this->drafts[] = $draft;
            $draft->setUserId($this);
        }

        return $this;
    }

    public function removeDraft(Draft $draft): self
    {
        if ($this->drafts->contains($draft)) {
            $this->drafts->removeElement($draft);
            // set the owning side to null (unless already changed)
            if ($draft->getUserId() === $this) {
                $draft->setUserId(null);
            }
        }

        return $this;
    }

}