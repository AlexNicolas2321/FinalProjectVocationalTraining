<?php
// src/Controller/RolesController.php
namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    
    #[Route('/api/createRole', name: 'create_roles', methods: ['POST'])]
    public function createRole(EntityManagerInterface $em,Request $request): JsonResponse{
        $data = json_decode($request->getContent(), true);

        $role = new Role();
        $role->setName($data["name"]);

        $em->persist($role);
        $em->flush($role);

        return new JsonResponse([
            'message' => 'creado nuevo rol'
        ]);
        

    
}
}