<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tournaments")
 */
class Tournament {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     *
     * from Dota2 API (when ticketed)
     */
    private $valve_league_id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotBlank()
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetimetz")
     * @Assert\NotBlank()
     */
    private $end_date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\League", inversedBy="tournaments")
     */
    private $leagues;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", inversedBy="tournaments")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="tournament")
     */
    private $matches;

    /**
     * @ORM\Column(type="float")
     *
     * weight multiplier to scale some tourneys over others (i.e. TI/majors count for more)
     */
    private $fantasy_weight;

    public function __construct()
    {
        $this->leagues = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValveLeagueId(): ?int
    {
        return $this->valve_league_id;
    }

    public function setValveLeagueId(?int $valve_league_id): self
    {
        $this->valve_league_id = $valve_league_id;
        return $this;
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
     * @return Collection|League[]
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues[] = $league;
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        if ($this->leagues->contains($league)) {
            $this->leagues->removeElement($league);
        }

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }
        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }
        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->setTournament($this);
        }
        return $this;
    }

    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            // set the owning side to null (unless already changed)
            if ($match->getTournament() === $this) {
                $match->setTournament(null);
            }
        }
        return $this;
    }

    public function getFantasyWeight(): ?float
    {
        return $this->fantasy_weight;
    }

    public function setFantasyWeight(float $fantasy_weight): self
    {
        $this->fantasy_weight = $fantasy_weight;
        return $this;
    }

}