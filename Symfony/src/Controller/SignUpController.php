<?php
// src/Controller/SignUpController.php
namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\RoleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[Route('/api/signUp', name: 'signUp', methods: ['POST'])]
    public function signup(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['dni'])) {
            return new JsonResponse(['error' => 'Faltan datos obligatorios'], 400);
        }

        $user = new User();
        $user->setDni($data['dni']);

        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);

        
        $role = $this->roleRepository->findOneBy(['name' => 'patient']);
        if ($role) {
            $userRole = new UserRole();
            $userRole->setRole($role);
            $userRole->setUser($user);
            $user->addUserRole($userRole);
            $entityManager->persist($userRole);
        }

        
        $patient = new Patient();
        $patient->setUser($user);
        $patient->setFirstName($data['first_name'] ?? '');
        $patient->setLastName($data['last_name'] ?? '');
        $patient->setPhone($data['phone'] ?? '');
        $patient->setBirthDate(isset($data['birth_date']) ? new \DateTime($data['birth_date']) : null);
        $createdAt = new DateTime($data["created_at"]);
        $patient->setCreatedAt($createdAt);
        

        $entityManager->persist($user);
        $entityManager->persist($patient);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Paciente registrado correctamente'], 201);
    }
}
