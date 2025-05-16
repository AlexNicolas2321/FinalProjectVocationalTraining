<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $amount;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $issued_at;

    #[ORM\Column(length: 50)]
    private string $status;

    #[ORM\OneToOne(inversedBy: 'invoice', targetEntity: Appointment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Appointment $appointment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getIssuedAt(): \DateTimeInterface
    {
        return $this->issued_at;
    }

    public function setIssuedAt(\DateTimeInterface $issued_at): self
    {
        $this->issued_at = $issued_at;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
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
}
