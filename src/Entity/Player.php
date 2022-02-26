<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $strength;

    #[ORM\Column(type: 'integer')]
    private $memory;

    #[ORM\Column(type: 'integer')]
    private $intelligence;

    #[ORM\Column(type: 'integer')]
    private $logic;

    #[ORM\Column(type: 'integer')]
    private $resistance;

    #[ORM\Column(type: 'integer')]
    private $fighting;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getMemory(): ?int
    {
        return $this->memory;
    }

    public function setMemory(int $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getLogic(): ?int
    {
        return $this->logic;
    }

    public function setLogic(int $logic): self
    {
        $this->logic = $logic;

        return $this;
    }

    public function getResistance(): ?int
    {
        return $this->resistance;
    }

    public function setResistance(int $resistance): self
    {
        $this->resistance = $resistance;

        return $this;
    }

    public function getFighting(): ?int
    {
        return $this->fighting;
    }

    public function setFighting(int $fighting): self
    {
        $this->fighting = $fighting;

        return $this;
    }

    public function getTeam(): ?int
    {
        return $this->team;
    }

    public function setTeam(?int $team): self
    {
        $this->team = $team;

        return $this;
    }

    
    public function buildArray(){
        $array = array();
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['strength'] = $this->getStrength();
        $array['intelligence'] = $this->getIntelligence();
        $array['memory'] = $this->getMemory();
        $array['logic'] = $this->getLogic();
        $array['resistance'] = $this->getResistance();
        $array['fighting'] = $this->getFighting();
  
        return $array;
      }


}
