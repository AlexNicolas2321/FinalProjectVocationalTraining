<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Receptionist;
use App\Entity\UserRole;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;
    private RoleRepository $roleRepository;

    public function __construct(EntityManagerInterface $em, RoleRepository $roleRepository)
    {
        $this->em = $em;
        $this->roleRepository = $roleRepository;
    }

    #[Route('api/getAllUsers', name: 'app_users_list', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->getAllUsers();
        return new JsonResponse($users);
    }

    #[Route('/api/admin', name: 'create_admin', methods: ['POST'])]
    public function createAdmin(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || empty($data['dni']) || empty($data['password'])) {
            return $this->json(['error' => 'Campos dni y password son obligatorios'], 400);
        }

        $user = new User();
        $user->setDni($data['dni']);
        $password=password_hash($data["password"],PASSWORD_DEFAULT);
        $user->setPassword($password);


        if (!empty($data['roles']) && is_array($data['roles'])) {
            foreach ($data['roles'] as $roleId) {
                $role = $this->roleRepository->find($roleId);
                if ($role) {
                    $userRole = new UserRole();
                    $userRole->setRole($role);
                    $userRole->setUser($user);
                    $user->addUserRole($userRole); // ahora sí es un UserRole
                }
            }
        }


        $this->em->persist($user);
        $this->em->flush();

        return $this->json(['message' => 'Administrador creado correctamente', 'id' => $user->getId()], 201);
    }

    #[Route('/api/notAdmin', name: 'create_user_with_details', methods: ['POST'])]
    public function createUserWithDetails(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || empty($data['dni']) || empty($data['password']) || empty($data['user_type'])) {
            return $this->json(['error' => 'Faltan campos obligatorios (dni, password, user_type)'], 400);
        }

        $user = new User();
        $user->setDni($data['dni']);
        $password=password_hash($data["password"],PASSWORD_DEFAULT);
        $user->setPassword($password);


        if (!empty($data['roles']) && is_array($data['roles'])) {
            foreach ($data['roles'] as $roleId) {
                $role = $this->roleRepository->find($roleId);
                if ($role) {
                    $userRole = new UserRole();
                    $userRole->setRole($role);
                    $userRole->setUser($user);
                    $user->addUserRole($userRole); // ahora sí es un UserRole
                }
            }
        }

        $this->em->persist($user);
        $this->em->flush();

        switch ($data['user_type']) {
            case 'doctor':
                $doctor = new Doctor();
                $doctor->setUser($user);
                $doctor->setFirstName($data['first_name'] ?? '');
                $doctor->setLastName($data['last_name'] ?? '');
                $doctor->setPhone($data['phone'] ?? '');
                $doctor->setSpeciality($data['speciality'] ?? '');
                $this->em->persist($doctor);
                break;

            case 'receptionist':
                $receptionist = new Receptionist();
                $receptionist->setUser($user);
                $receptionist->setFirstName($data['first_name'] ?? '');
                $receptionist->setLastName($data['last_name'] ?? '');
                $receptionist->setPhone($data['phone'] ?? '');
                $this->em->persist($receptionist);
                break;

            default:
                return $this->json(['error' => 'Tipo de usuario no válido'], 400);
        }

        $this->em->flush();

        return $this->json(['message' => 'Usuario creado correctamente', 'id' => $user->getId()], 201);
    }


   /* #[Route('/api/roles/{id}', name: 'test_user_roles', methods: ['GET'])]
    public function testUserRoles(int $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['error' => "User with ID $id not found"], 404);
        }

        // Usamos el método getRoles() que devuelve los roles
        $roles = $user->getRoles();

        return new JsonResponse([
            'user_id' => $user->getId(),
            'roles' => $roles,
        ]);
    }*/
}
