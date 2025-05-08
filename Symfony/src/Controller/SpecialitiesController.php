<?php
namespace App\Controller;

use App\Repository\SpecialityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SpecialitiesController extends AbstractController
{
    #[Route('/api/getAllSpecialities', name: 'getAllSpecialities', methods: ['GET'])]
    public function search(SpecialityRepository $speciality_repository): JsonResponse
    {
        
        $specialities_id_and_name = $speciality_repository->specialities_id_and_name();
        
        return $this->json($specialities_id_and_name);
    }
}
