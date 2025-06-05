<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Receptionist;
use App\Entity\Role;
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

    #[Route('api/getUserByDni/{dni}', name: 'getUserByDni', methods: ['GET'])]
    public function getUserByDni(string $dni,EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findOneBy(['dni' => $dni]);
        $patient = $user->getPatient();

        if (!$patient) {
            return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
        }
        $data[]=[
            "dni" =>$user->getDni(),
            "first_name" => $patient->getFirstName(),
            "last_name" => $patient->getLastName(),
            "phone" => $patient->getPhone(),
            "email" => $patient->getEmail(),
        ];

        return new JsonResponse($data);
    }

    #[Route('api/getAllPatients', name: 'get_all_patients', methods: ['GET'])]
    public function getAllPatients(): JsonResponse
    {
        $data=[];
        $users = $this->em->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            if($user->getPatient()){
               $patient=$user->getPatient(); 
                $data[]=[
                    "dni" =>$user->getDni(),
                    "first_name" => $patient->getFirstName(),
                    "last_name" => $patient->getLastName(),
                    "phone" => $patient->getPhone(),
                    "birth_date" => $patient->getBirthDate(),
                    "email" => $patient->getEmail(),

                ];
            }
        }
        return new JsonResponse($data);
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
    #[Route('/api/editRoleUser', name: 'edit_role_user', methods: ['PATCH'])]
    public function editRoleUser(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        $user = $userRepository->find($data["id"]);
        if (!$user) {
            return new JsonResponse(["message" => "Usuario no encontrado"], 404);
        }
    
        // Eliminar los antiguos UserRole de la BBDD
        foreach ($user->getUserRoles() as $userRole) {
            $em->remove($userRole);
        }
        
        
    
        
        foreach ($data["role"] as $roleName) {
            $role = $em->getRepository(Role::class)->findOneBy(["name" => $roleName]);
            if ($role) {
                $userRole = new UserRole();
                $userRole->setRole($role);
                $userRole->setUser($user);
                $em->persist($userRole); 
                $user->addUserRole($userRole);
            }
        }
    
        $em->flush();
    
        return new JsonResponse([
            "message" => "Actualizado con éxito",
            "roles" => $user->getRoles()
        ]);
    }
        
}
