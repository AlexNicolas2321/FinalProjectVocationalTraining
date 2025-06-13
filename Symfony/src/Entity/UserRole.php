<?php

namespace App\Entity;

use App\Repository\UserRoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(options: ["charset" => "utf8mb4", "collate" => "utf8mb4_unicode_ci"])]
#[ORM\Entity(repositoryClass: UserRoleRepository::class)]
class UserRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime" , nullable:true)]
    private \DateTimeInterface $assigned_at;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'userRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private Role $role;

    public function __construct()
{
    $this->assigned_at = new \DateTime();
}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignedAt(): \DateTimeInterface
    {
        return $this->assigned_at;
    }

    public function setAssignedAt(\DateTimeInterface $assigned_at): self
    {
        $this->assigned_at = $assigned_at;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }
}
