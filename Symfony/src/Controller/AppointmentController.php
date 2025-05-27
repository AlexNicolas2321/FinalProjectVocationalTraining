<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Treatment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;

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
        $appointment->setObservation($data['observations'] ?? null);
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
            $patient = $em->getRepository(Patient::class)->find($appointment->getPatient());
            $user = $em->getRepository(User::class)->find($patient->getUser());
            $treatment = $doctor->getTreatment();
            $data[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'observations' => $appointment->getObservation(),
                'state' => $appointment->getStatus(),
                'doctor_first_name' => $doctor->getFirstName(),
                'doctor_last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
                'patient_first_name' => $patient->getFirstName(),
                'patient_last_name' => $patient->getLastName(),
                'patient_phone' => $patient->getPhone(),
                'user_dni' => $user->getDni(),
                

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
                'observations' => $appointment->getObservation(),
                'first_name' => $doctor->getFirstName(),
                'last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
                'state' => $appointment->getStatus(),
            ];
        }


        return new JsonResponse($data, 200);
    }

    #[Route('/api/editeAppointmentStatus/{id}', name: 'edit_appointments_status', methods: ['PATCH'])]
    public function editeAppointment(int $id,EntityManagerInterface $em,Request $request): JsonResponse
    {
        $appointment = $em->getRepository(Appointment::class)->find($id);

        $data = json_decode($request->getContent(), true);
        
        if(isset($data["status"])){
            $appointment->setStatus($data["status"]);
        }
        $em->flush();

        return $this->json([
            'message' => "appointment updated successfully",
                "Appointment" => [
                    "id" => $appointment->getId(),
                    'status' => $appointment->getStatus(),
                ]
        ]);
    }

    #[Route('/api/editeAppointmentObservation/{id}', name: 'edit_appointments_observation', methods: ['PATCH'])]
    public function editeAppointmentObservation(int $id,EntityManagerInterface $em,Request $request): JsonResponse{

        $data=json_decode($request->getContent(),true);
        
        $appointment = $em->getRepository(Appointment::class)->find($id);

        $appointment->setObservation($data["observation"]);

        $em->flush();

        return new JsonResponse([
            "message" => "updated observation",
            "observation" => $appointment->getObservation(),
        ]);
    }





}
