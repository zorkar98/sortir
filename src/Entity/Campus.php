<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Outing::class)]
    private $outing;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Outing::class)]
    private $campus_outing;

    public function __construct()
    {
        $this->outing = new ArrayCollection();
        $this->campus_outing = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Outing>
     */
    public function getOuting(): Collection
    {
        return $this->outing;
    }

    public function addOuting(Outing $outing): self
    {
        if (!$this->outing->contains($outing)) {
            $this->outing[] = $outing;
            $outing->setCampus($this);
        }

        return $this;
    }

    public function removeOuting(Outing $outing): self
    {
        if ($this->outing->removeElement($outing)) {
            // set the owning side to null (unless already changed)
            if ($outing->getCampus() === $this) {
                $outing->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Outing>
     */
    public function getCampusOuting(): Collection
    {
        return $this->campus_outing;
    }

    public function addCampusOuting(Outing $campusOuting): self
    {
        if (!$this->campus_outing->contains($campusOuting)) {
            $this->campus_outing[] = $campusOuting;
            $campusOuting->setCampus($this);
        }

        return $this;
    }

    public function removeCampusOuting(Outing $campusOuting): self
    {
        if ($this->campus_outing->removeElement($campusOuting)) {
            // set the owning side to null (unless already changed)
            if ($campusOuting->getCampus() === $this) {
                $campusOuting->setCampus(null);
            }
        }

        return $this;
    }


}
