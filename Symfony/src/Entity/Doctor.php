<?php

namespace App\Entity;

use App\Repository\DoctorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: 'Doctor')]
#[ORM\Entity]
class Doctor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $first_name;

    #[ORM\Column(length: 100)]
    private $last_name;

    #[ORM\ManyToOne(targetEntity: Specialty::class)]
    private $speciality;

    #[ORM\OneToMany(mappedBy: 'dentista', targetEntity: Appointment::class)]
    private $appointmet;
}
