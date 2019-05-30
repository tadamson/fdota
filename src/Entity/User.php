<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knojector\SteamAuthenticationBundle\User\AbstractSteamUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity()
 */
class User extends AbstractSteamUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $date_created;

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

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(?\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;
        return $this;
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
            $draft->setUser($this);
        }

        return $this;
    }

    public function removeDraft(Draft $draft): self
    {
        if ($this->drafts->contains($draft)) {
            $this->drafts->removeElement($draft);
            // set the owning side to null (unless already changed)
            if ($draft->getUser() === $this) {
                $draft->setUser(null);
            }
        }

        return $this;
    }

}