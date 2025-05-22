<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Treatment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppointmentController extends AbstractController
{
    #[Route('/api/createAppointment', name: 'create_appointment', methods: ['POST'])]
    public function createAppointment(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $patient = $em->getRepository(Patient::class)->findOneBy(['user' => $data['userId']]);
        $doctor = $em->getRepository(Doctor::class)->find($data['doctorId']);

        if (!$patient || !$doctor) {
            return new JsonResponse(['error' => 'Invalid patient or doctor ID'], 400);
        }

        $appointment = new Appointment();
        $appointment->setDate(new \DateTime($data['date']));
        $appointment->setObservations($data['observations'] ?? null);
        $appointment->setCreatedAt(new \DateTime('Europe/Madrid'));
        $appointment->setPatient($patient);
        $appointment->setDoctor($doctor);

        $em->persist($appointment);
        $em->flush();

        return new JsonResponse(['message' => 'Appointment created successfully'], 201);
    }

    #[Route('/api/getAllAppointments', name: 'get_all_appointments', methods: ['GET'])]
    public function getAllAppointments(EntityManagerInterface $em): JsonResponse
    {
        $appointments = $em->getRepository(Appointment::class)->findAll();

        $data = [];
        foreach ($appointments as $appointment) {
            $doctor = $em->getRepository(Doctor::class)->find($appointment->getDoctor());
            $treatment = $doctor->getTreatment();
            $data[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'observations' => $appointment->getObservations(),
                'first_name' => $doctor->getFirstName(),
                'last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
            ];
        }

        return new JsonResponse($data, 200);
    }

    #[Route('/api/getSpecificAppointments/{id}', name: 'get_specific_appointments', methods: ['GET'])]
    public function getSpecificAppointments(int $id, EntityManagerInterface $em): JsonResponse
    {

    

        $patient = $em->getRepository(Patient::class)->findoneBy(['user' => $id]);

      
        $appointments = $em->getRepository(Appointment::class)->findBy(['patient' => $patient]);

        $data = [];

        foreach ($appointments as $appointment) {
            $doctor = $em->getRepository(Doctor::class)->find($appointment->getDoctor());
            $treatment = $doctor->getTreatment();

            $data[] = [
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'observations' => $appointment->getObservations(),
                'first_name' => $doctor->getFirstName(),
                'last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
            ];
        }


        return new JsonResponse($data, 200);
    }
}
