<?php
// src/Controller/RolesController.php
namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    #[Route('/api/getAllRoles', name: 'get_all_roles', methods: ['GET'])]
    public function getAllRoles(RoleRepository $roleRepository): JsonResponse
    {
        $roles = $roleRepository->findAll();

        $data = [];

        foreach ($roles as $role) {
            $data[] = [
                'id' => $role->getId(),
                'name' => $role->getName(),
            ];
        }

        return $this->json($data);
    }
}
