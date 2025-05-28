<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Base price of the treatment (without tax)
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $baseAmount;

    // Tax rate in percent (e.g. 21)
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private string $taxRate;

    // Tax amount (calculated: baseAmount * (taxRate / 100))
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $taxAmount;

    // Total amount (baseAmount + taxAmount)
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $totalAmount;

    // Date of issue
    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $issuedAt;

    // Status (e.g. pending, paid, canceled)
    #[ORM\Column(length: 50)]
    private string $status;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $pdfFile = null;

    // Link to appointment
    #[ORM\OneToOne(inversedBy: 'invoice', targetEntity: Appointment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Appointment $appointment;

    // --- Getters and Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseAmount(): string
    {
        return $this->baseAmount;
    }

    public function setBaseAmount(string $baseAmount): self
    {
        $this->baseAmount = $baseAmount;
        return $this;
    }

    public function getTaxRate(): string
    {
        return $this->taxRate;
    }

    public function setTaxRate(string $taxRate): self
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    public function getTaxAmount(): string
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(string $taxAmount): self
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    public function getTotalAmount(): string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function getIssuedAt(): \DateTimeImmutable
    {
        return $this->issuedAt;
    }
    public function setIssuedAt(\DateTimeImmutable $issuedAt): self
    {
        $this->issuedAt = $issuedAt;
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

    public function getPdfFile(): ?string
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?string $pdfFile): self
    {
        $this->pdfFile = $pdfFile;
        return $this;
    }
}
