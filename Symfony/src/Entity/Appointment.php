<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ORM\Table(name: 'Appointment')]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\ManyToOne(targetEntity: LeadPatient::class, inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LeadPatient $leadPatient = null;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctor $doctor = null;

    #[ORM\Column(type: 'boolean')]
    private bool $deleted = false;

    #[ORM\ManyToOne(targetEntity: Treatment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Treatment $treatment = null;

    #[ORM\OneToOne(mappedBy: 'appointment', targetEntity: Invoice::class, cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getLeadPatient(): ?LeadPatient
    {
        return $this->leadPatient;
    }

    public function setLeadPatient(?LeadPatient $leadPatient): self
    {
        $this->leadPatient = $leadPatient;
        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;
        return $this;
    }

    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(?Treatment $treatment): self
    {
        $this->treatment = $treatment;
        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        if ($invoice && $invoice->getAppointment() !== $this) {
            $invoice->setAppointment($this);
        }

        $this->invoice = $invoice;
        return $this;
    }
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
