<?php

namespace App\Entity;

use App\Repository\TreatmentPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreatmentPlanRepository::class)]
#[ORM\Table(name: 'TreatmentPlan')]
class TreatmentPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Appointment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Appointment $appointment;

    #[ORM\ManyToOne(targetEntity: LeadPatient::class)]
    #[ORM\JoinColumn(nullable: false)]
    private LeadPatient $leadPatient;

    #[ORM\ManyToOne(targetEntity: Doctor::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Doctor $dentist;

    #[ORM\ManyToOne(targetEntity: Treatment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Treatment $treatment;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    // --- Getters and Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointment(): Appointment
    {
        return $this->appointment;
    }

    public function setAppointment(Appointment $appointment): self
    {
        $this->appointment = $appointment;
        return $this;
    }

    public function getLeadPatient(): LeadPatient
    {
        return $this->leadPatient;
    }

    public function setPatient(LeadPatient $leadPatient): self
    {
        $this->leadPatient = $leadPatient;
        return $this;
    }

    public function getDentist(): Doctor
    {
        return $this->dentist;
    }

    public function setDentist(Doctor $dentist): self
    {
        $this->dentist = $dentist;
        return $this;
    }

    public function getTreatment(): Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(Treatment $treatment): self
    {
        $this->treatment = $treatment;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
