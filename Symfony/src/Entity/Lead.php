<?php

namespace App\Entity;

use App\Repository\LeadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadRepository::class)]
#[ORM\Table(name: 'Lead')]
#[ORM\Entity]
class Lead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 100)]
    private $firstName;

    #[ORM\Column(length: 100)]
    private $lastName;

    #[ORM\Column(length: 150)]
    private $email;

    #[ORM\Column(length: 20, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    private $message;

    #[ORM\Column(type: 'datetime')]
    private $submittedAt;

    #[ORM\Column(type: 'boolean')]
    private $converted = false;

    #[ORM\Column(type: 'boolean')]
    private $deleted = false;

    #[ORM\ManyToOne(targetEntity: Treatment::class , nullable: true)]
    private $interestedTreatment;
}
