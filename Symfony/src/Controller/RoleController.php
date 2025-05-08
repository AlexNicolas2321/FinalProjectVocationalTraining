<?php
namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    #[Route('/api/getAllRoles', name: 'getAllRoles', methods: ['GET'])]
    public function search(RoleRepository $roles_repository): JsonResponse
    {
        
        $roles = $roles_repository->getAllRoles();
        
        return $this->json($roles);
    }
}
