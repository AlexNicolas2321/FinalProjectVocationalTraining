<?php
namespace App\Entity;

use App\Repository\TreatmentPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreatmentPlanRepository::class)]
#[ORM\Table(name: 'Treatment')]#[ORM\Entity]
class TreatmentPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Appointment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $appointment;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $patient;

    #[ORM\ManyToOne(targetEntity: Doctor::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $dentist;

    #[ORM\ManyToOne(targetEntity: Treatment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $treatment;

    #[ORM\Column(type: 'text', nullable: true)]
    private $notes;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;
}
