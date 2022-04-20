<?php

namespace App\Entity;

use App\Repository\OutingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutingRepository::class)]
class Outing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $dateCreated;

    #[ORM\Column(type: 'datetime')]
    private $startDateTime;

    #[ORM\Column(type: 'integer')]
    private $duration;

    #[ORM\Column(type: 'datetime')]
    private $deadlineRegistration;

    #[ORM\Column(type: 'integer')]
    private $registrationMaxNb;

    #[ORM\Column(type: 'string', length: 255)]
    private $outingInfo;

    #[ORM\Column(type: 'string', length: 255)]
    private $state;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'outings')]
    private $User;

    #[ORM\Column(type: 'string', length: 255)]
    private $Author;

    #[ORM\Column(type: 'array', nullable: true)]
    private $participants = [];

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'campus_outing')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;



    public function __construct()
    {
        $this->User = new ArrayCollection();

        $this->startDateTime = new \DateTime();

        $this->deadlineRegistration = new \DateTime('-1 day');
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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }


    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDeadlineRegistration(): ?\DateTimeInterface
    {
        return $this->deadlineRegistration;
    }

    public function setDeadlineRegistration(\DateTimeInterface $deadlineRegistration): self
    {
        $this->deadlineRegistration = $deadlineRegistration;

        return $this;
    }

    public function getRegistrationMaxNb(): ?int
    {
        return $this->registrationMaxNb;
    }

    public function setRegistrationMaxNb(int $registrationMaxNb): self
    {
        $this->registrationMaxNb = $registrationMaxNb;

        return $this;
    }

    public function getOutingInfo(): ?string
    {
        return $this->outingInfo;
    }

    public function setOutingInfo(string $outingInfo): self
    {
        $this->outingInfo = $outingInfo;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->User->removeElement($user);

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    public function setAuthor(string $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    public function getParticipants(): ?array
    {
        return $this->participants;
    }

    public function setParticipants(?array $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }



}
