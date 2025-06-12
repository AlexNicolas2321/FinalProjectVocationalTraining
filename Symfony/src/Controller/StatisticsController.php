<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\AppointmentRepository;
use App\Repository\TreatmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    #[Route('/api/statistics', name: 'api_statistics', methods: ['GET'])]
    public function getStatistics(UserRepository $userRepository,AppointmentRepository $appointmentRepository,TreatmentRepository $treatmentRepository): JsonResponse {
        
        return $this->json([
            'totalUsers' => $userRepository->totalUsers(),
            'totalAppointments' => $appointmentRepository->totalAppointments(),
            'treatmentStats' => $treatmentRepository->totalOfEachTreatments(),
            'mostUsedTreatment' => $treatmentRepository->mostUsedTreatment()
        ]);
    }
}
