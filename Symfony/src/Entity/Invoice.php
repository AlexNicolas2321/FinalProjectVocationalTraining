<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ORM\Table(name: 'Invoice')]
#[ORM\Entity]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $issuedAt;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $total;

    #[ORM\OneToOne(inversedBy: 'invoice', targetEntity: Appointment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $appointment;
}
