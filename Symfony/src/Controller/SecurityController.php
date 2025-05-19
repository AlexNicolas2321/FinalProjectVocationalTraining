<?php

// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController
{
    #[Route('/login', name: 'app_login')]
    public function login(): JsonResponse
    {
        return new JsonResponse(['error' => 'Authentication required'], 401);
    }
}
