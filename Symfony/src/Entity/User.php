<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface , PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100,unique:true)]
    private string $dni;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserRole::class, cascade: ['persist', 'remove'])]
    private Collection $userRoles;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Patient::class, cascade: ['persist', 'remove'])]
    private ?Patient $patient = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Doctor::class, cascade: ['persist', 'remove'])]
    private ?Doctor $doctor = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Receptionist::class, cascade: ['persist', 'remove'])]
    private ?Receptionist $receptionist = null;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

   

    
    public function getRoles(): array
    {
        $roles = [];
    
        foreach ($this->userRoles as $userRole) {
            // Suponiendo que getRole() devuelve un string con el nombre del rol
            $role = $userRole->getRole();
            if ($role) {
                $roles[] = $role->getName();
            }
        }
    
        // Devuelve solo roles únicos, para evitar duplicados
        return array_unique($roles);
    }
    


    public function addUserRole(UserRole $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->setUser($this);
        }

        return $this;
    }

    public function removeUserRole(UserRole $userRole): self
    {
        if ($this->userRoles->removeElement($userRole)) {
            
        }

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;
        return $this;
    }

    public function getReceptionist(): ?Receptionist
    {
        return $this->receptionist;
    }

    public function setReceptionist(?Receptionist $receptionist): self
    {
        $this->receptionist = $receptionist;
        return $this;
    }
    public function getUserIdentifier(): string
    {
        return $this->dni; 
    }
    public function eraseCredentials(): void {}

}
