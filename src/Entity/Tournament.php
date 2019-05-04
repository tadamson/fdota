<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tournament")
 */
class Tournament {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="auto")
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


}