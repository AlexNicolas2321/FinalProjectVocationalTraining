<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ORM\Table(name: 'Appointment')]
#[ORM\Entity]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateTime;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'appointments')]
    private $patient;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'appointments')]
    private $doctor;

    #[ORM\ManyToOne(targetEntity: Treatment::class)]
    private $treatment;

    #[ORM\OneToOne(mappedBy: 'appointment', targetEntity: Invoice::class)]
    private $invoice;
}
