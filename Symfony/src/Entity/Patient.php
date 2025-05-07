<?php
namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: 'Patient')]
#[ORM\Entity]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $first_name;

    #[ORM\Column(length: 100)]
    private $last_name;

    #[ORM\Column(length: 20)]
    private $phone;

    #[ORM\Column(length: 150)]
    private $email;

    #[ORM\Column(type: 'date')]
    private $birth_date;

    #[ORM\OneToMany(mappedBy: 'paciente', targetEntity: $Appointments::class)]
    private $appointments;
}
