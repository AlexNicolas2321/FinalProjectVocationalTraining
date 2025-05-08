<?php

namespace App\Entity;

use App\Repository\LeadPatientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: LeadPatientRepository::class)]
#[ORM\Table(name: 'LeadPatient')]
class LeadPatient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Appointment::class, mappedBy: 'leadPatient')]
    private Collection $appointments;

    #[ORM\Column(length: 100)]
    private string $firstName;

    #[ORM\Column(length: 100)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 9)]
    private string $dni;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone;

    #[ORM\Column(length: 150)]
    private string $email;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $birthDate;

    #[ORM\Column(type: 'boolean')]
    private bool $isLead = true;  // Is a lead or a real patient (has kept an appointment?)

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $submittedAt;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    // Métodos Getters y Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function isIsLead(): bool
    {
        return $this->isLead;
    }

    public function setIsLead(bool $isLead): self
    {
        $this->isLead = $isLead;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setLeadPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            $appointment->setDeleted(true);
        }

        return $this;
    }
}
