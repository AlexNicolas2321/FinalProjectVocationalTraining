<?php
namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
#[ORM\Table(name: 'Speciality')]


#[ORM\Entity]
class Specialty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'specialty', targetEntity: Doctor::class)]
    private $dentists;
}
