<?php


namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'treatment', targetEntity: Appointment::class)]
    private Collection $appointments;


    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function addAppointment(Appointment $appointment): self
{
    if (!$this->appointments->contains($appointment)) {
        $this->appointments[] = $appointment;
        $appointment->setTreatment($this);
    }

    return $this;
}

public function removeAppointment(Appointment $appointment): self
{
    if ($this->appointments->removeElement($appointment)) {
        if ($appointment->getTreatment() === $this) {
            //$appointment->setTreatment(null);
        }
    }

    return $this;
}

}
