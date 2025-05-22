<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    #[Route('/api/getAllDoctors', name: 'get_doctors', methods: ['GET'])]
    public function getDoctors(DoctorRepository $doctorRepository): JsonResponse
    {
        $doctors = $doctorRepository->findAll();

        $data = [];

        foreach ($doctors as $doctor) {
            $user = $doctor->getUser();
            $data[] = [
                'id' => $doctor->getId(),
                'firstName' => $doctor->getFirstName(),
                'lastName' => $doctor->getLastName(),
                'speciality' => $doctor->getSpeciality(),
                'dni' => $user->getDni(),
            ];
        }

        return $this->json($data);
    }
}
