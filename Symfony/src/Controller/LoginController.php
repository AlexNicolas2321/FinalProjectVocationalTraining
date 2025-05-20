<?php

// src/Controller/AuthController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Entity\User;

class LoginController extends AbstractController
{
    private $em;
    private $passwordHasher;
    private $jwtManager;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $jwtManager)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
    }

    #[Route('/api/signIn', name: 'api_signin', methods: ['POST'])]
    public function signIn(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dni = $data['dni'] ?? null;
        $password = $data['password'] ?? null;

      
        if (!$dni || !$password) {
            return new JsonResponse(['error' => 'DNI and password are required'], 400);
        }

        // Buscar usuario por DNI
        $user = $this->em->getRepository(User::class)->findOneBy(['dni' => $dni]);
        
        $payload=[
            "user_id" => $user->getId(),
            'dni' => $user->getDni(),
            'roles' => $user->getUserRoles()
        ];


        if (!$user) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        // Verificar contraseña
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        // Generar token JWT
        $token = $this->jwtManager->createFromPayload($user,$payload);

        return new JsonResponse(['token' => $token]);
    }
}
