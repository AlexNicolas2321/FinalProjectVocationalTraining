<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/getAllUsers', name: 'getAllUsers', methods: ['GET'])]
    public function search(UserRepository $user_repository): JsonResponse
    {
        
        $users = $user_repository->getAllUsers();
        
        return $this->json($users);
    }
}
