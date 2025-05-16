<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $date;

    #[ORM\Column(length: 255)]
    private string $treatment_name;

    #[ORM\Column(type: 'text')]
    private string $treatment_description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $treatment_price;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Patient $patient;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Doctor $doctor;

    #[ORM\OneToOne(mappedBy: 'appointment', targetEntity: Invoice::class, cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTreatmentName(): string
    {
        return $this->treatment_name;
    }

    public function setTreatmentName(string $treatment_name): self
    {
        $this->treatment_name = $treatment_name;
        return $this;
    }

    public function getTreatmentDescription(): string
    {
        return $this->treatment_description;
    }

    public function setTreatmentDescription(string $treatment_description): self
    {
        $this->treatment_description = $treatment_description;
        return $this;
    }

    public function getTreatmentPrice(): string
    {
        return $this->treatment_price;
    }

    public function setTreatmentPrice(string $treatment_price): self
    {
        $this->treatment_price = $treatment_price;
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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): self
    {
        $this->doctor = $doctor;
        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        if ($invoice !== null && $invoice->getAppointment() !== $this) {
            $invoice->setAppointment($this);
        }

        return $this;
    }
}
