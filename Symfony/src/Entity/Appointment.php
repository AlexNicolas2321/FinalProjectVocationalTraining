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
   
    #[ORM\Column(length: 20)]
    private string $status = "pending";

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $observations;

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

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;
        return $this;
    }
    
    public function getStatus(): string{
        return $this->status;
    }

    public function setStatus(string $status): self{
        $allowedstatuss = ['pending', 'confirmed', 'cancelled'];

        if(!in_array($status,$allowedstatuss,true)){
            throw new \InvalidArgumentException(sprintf('Estado "%s" no válido. Los valores permitidos son: %s', $status, implode(', ', $allowedstatuss)));
        }
        $this->status= $status;

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
