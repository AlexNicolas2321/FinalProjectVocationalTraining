<?php
namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
#[ORM\Table(name: 'Treatment')]
#[ORM\Entity]

class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $price;
}
