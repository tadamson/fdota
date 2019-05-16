<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="leagues")
 *
 * Leagues are 1+ tournaments i.e. for combining multiple small tourneys that wouldn't be very interesting on their own.
 * Major tournaments will be 1:1 with leagues, but this allows for multiple overlapping leagues (e.g. an entire 3 month
 * block or whatever, salt to taste)
 */
class League {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     *
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotNull()
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotNull()
     */
    private $end_date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tournament", mappedBy="League")
     */
    private $tournaments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Draft", mappedBy="league_id")
     */
    private $drafts;

    public function __construct()
    {
        $this->tournaments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * @return Collection|Tournament[]
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    /**
     * @param Tournament $tournament
     * @return League
     */
    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments[] = $tournament;
            $tournament->addLeague($this);
        }

        return $this;
    }

    /**
     * @param Tournament $tournament
     * @return League
     */
    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->contains($tournament)) {
            $this->tournaments->removeElement($tournament);
            $tournament->removeLeague($this);
        }

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
            $draft->setLeagueId($this);
        }

        return $this;
    }

    public function removeDraft(Draft $draft): self
    {
        if ($this->drafts->contains($draft)) {
            $this->drafts->removeElement($draft);
            // set the owning side to null (unless already changed)
            if ($draft->getLeagueId() === $this) {
                $draft->setLeagueId(null);
            }
        }

        return $this;
    }
}