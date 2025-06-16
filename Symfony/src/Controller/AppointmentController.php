<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\User;
use App\Repository\AppointmentRepository;
use App\Service\createInvoiceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;

class AppointmentController extends AbstractController
{
    private createInvoiceService $invoiceService;

    public function __construct(createInvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        return new Response('El backend funciona correctamente');
    }

    #[Route('/', name: 'homepage')]
public function home(): Response
{
    return new Response('<h1>Bienvenido a la página principal</h1>');
}


    #[Route('/api/createAppointment', name: 'create_appointment', methods: ['POST'])]
    public function createAppointment(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT');

        $data = json_decode($request->getContent(), true);

        $patient = $em->getRepository(Patient::class)->findOneBy(['user' => $data['userId']]);
        $doctor = $em->getRepository(Doctor::class)->find($data['doctorId']);

        if (!$patient || !$doctor) {
            return new JsonResponse(['error' => 'Invalid patient or doctor ID'], 400);
        }

        $appointment = new Appointment();
        $appointment->setDate(new \DateTime($data['date']));
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
        if (!$this->isGranted('ROLE_RECEPTIONIST') && !$this->isGranted('ROLE_DOCTOR')) {
            throw $this->createAccessDeniedException('Access denied.');
        }

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
                'state' => $appointment->getStatus(),
                'doctor_first_name' => $doctor->getFirstName(),
                'doctor_last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
                'patient_first_name' => $patient->getFirstName(),
                'patient_last_name' => $patient->getLastName(),
                'patient_phone' => $patient->getPhone(),
                'user_dni' => $user->getDni(),
                'email' => $patient->getEmail(),

            ];
        }

        return new JsonResponse($data, 200);
    }

    #[Route('/api/editeAppointmentStatus/{id}', name: 'edit_appointments_status', methods: ['PATCH'])]
    public function editeAppointment(
        int $id,
        EntityManagerInterface $em,
        Request $request,
        MailerInterface $mailer
    ): JsonResponse {
        $this->denyAccessUnlessGranted('ROLE_RECEPTIONIST');

        $appointment = $em->getRepository(Appointment::class)->find($id);
        if (!$appointment) {
            return $this->json(['error' => 'Appointment not found.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data["status"])) {
            $appointment->setStatus($data["status"]);
            $patient = $appointment->getPatient();
            $patientMail = $patient->getEmail();

            if ($data["status"] === "confirmed") {
                $invoice = $this->invoiceService->createInvoiceForAppointment($appointment);

                $pdfContent = $invoice->getPdfFile();

                $email = (new Email())
                    ->from('epmticnotifications@gmail.com')
                    ->to($patientMail)
                    ->subject('Cita confirmada - Presupuesto adjunta')
                    ->text('Hola, tu cita ha sido confirmada. La Presupuesto está adjunta a este correo.')
                    ->attach($pdfContent, 'presupuesto.pdf', 'application/pdf');

                try {
                    $mailer->send($email);
                } catch (\Throwable $e) {
                    return $this->json([
                        'error' => 'No se pudo enviar el correo: ' . $e->getMessage()
                    ], 500);
                }
            }

            $em->flush();

            return $this->json([
                'message' => "Appointment updated successfully",
                "Appointment" => [
                    "id" => $appointment->getId(),
                    'status' => $appointment->getStatus(),
                ]
            ]);
        }

        return $this->json(['error' => 'Status not provided.'], 400);
    }


    #[Route('/api/editAppointmentStatus/{id}', name: 'edit_appointment_status', methods: ['PATCH'])]
    public function editAppointmentStatus(int $id, EntityManagerInterface $em, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_RECEPTIONIST');

        // Obtener la cita
        $appointment = $em->getRepository(Appointment::class)->find($id);
        $patient = $appointment->getPatient();
        // Validar existencia
        if (!$appointment) {
            return $this->json([
                'error' => 'Appointment not found.'
            ], 404);
        }

        // Decodificar datos
        $data = json_decode($request->getContent(), true);

        // Validar y actualizar estado
        if (isset($data['status'])) {
            $appointment->setStatus($data['status']);

            // Si está confirmado, crear factura
            if ($data['status'] === 'confirmed') {
                $this->invoiceService->createInvoiceForAppointment($appointment);
            }


            return $this->json([
                'message' => 'Appointment status updated successfully.',
                'appointment' => [
                    'id' => $appointment->getId(),
                    'status' => $appointment->getStatus(),
                ]
            ]);
        }

        // Si no se envió "status"
        return $this->json([
            'error' => 'Status not provided.'
        ], 400);
    }

    #[Route('/api/appointments/{id}/pdf', name: 'appointment_pdf', methods: ['GET'])]
    public function downloadPdf(int $id, AppointmentRepository $appointmentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_RECEPTIONIST');

        $appointment = $appointmentRepository->find($id);

        if (!$appointment) {
            return new Response('Cita no encontrada', Response::HTTP_NOT_FOUND);
        }

        $invoice = $appointment->getInvoice();

        $pdfContent = $invoice->getPdfFile();

        if (is_null($pdfContent) || $pdfContent === '' || strlen($pdfContent) === 0) {
            return new Response('PDF no disponible o vacío', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Opcional: guardar el PDF en disco (puedes comentar esta parte si no quieres guardar)
        $publicDir = $this->getParameter('kernel.project_dir') . '/public/pdfs';
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0777, true);
        }
        file_put_contents($publicDir . '/appointment_' . $id . '.pdf', $pdfContent);

        // Devolver el PDF para descarga o visualización
        $response = new Response($pdfContent);

        // Para que el navegador intente mostrarlo
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="appointment_' . $id . '.pdf"');

        return $response;
    }
    #[Route('/api/getSpecificAppointments/{id}', name: 'get_specific_appointments', methods: ['GET'])]
    public function getSpecificAppointments(int $id, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT');



        $patient = $em->getRepository(Patient::class)->findoneBy(['user' => $id]);


        $appointments = $em->getRepository(Appointment::class)->findBy(['patient' => $patient]);

        $data = [];

        foreach ($appointments as $appointment) {
            $doctor = $em->getRepository(Doctor::class)->find($appointment->getDoctor());
            $treatment = $doctor->getTreatment();

            $data[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'first_name' => $doctor->getFirstName(),
                'last_name' => $doctor->getLastName(),
                'treatment' => $treatment->getName(),
                'state' => $appointment->getStatus(),
            ];
        }


        return new JsonResponse($data, 200);
    }

    #[Route('/api/getSpecificAppointmentsDoctor/{id}', name: 'get_specific_appointments_doctor', methods: ['GET'])]
    public function getSpecificAppointmentsDoctor(int $id, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_DOCTOR');

        $doctor = $em->getRepository(Doctor::class)->findOneBy(['user' => $id]);
        if (!$doctor) {
            return new JsonResponse(['error' => 'Doctor no encontrado'], 404);
        }

        $appointments = $em->getRepository(Appointment::class)->findBy(['doctor' => $doctor]);

        $data = [];

        foreach ($appointments as $appointment) {
            $patient = $appointment->getPatient();
            $treatment = $doctor->getTreatment();
            $user = $patient->getUser();
            $data[] = [
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'user_dni' => $user ? $user->getDni() : null,
                'doctor_first_name' => $doctor->getFirstName(),
                'doctor_last_name' => $doctor->getLastName(),
                'treatment' => $treatment ? $treatment->getName() : null,
                'patient_first_name' => $patient ? $patient->getFirstName() : null,
                'patient_last_name' => $patient ? $patient->getLastName() : null,
                'patient_phone' => $patient ? $patient->getPhone() : null,
                'state' => $appointment->getStatus(),
            ];
        }

        return new JsonResponse($data, 200);
    }


    #[Route('/api/cancelAppointment/{id}', name: 'cancel_appointment', methods: ['PATCH'])]
    public function cancelAppointment(int $id, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT');

        $appointment = $em->getRepository(Appointment::class)->findOneBy(["id" => $id]);

        if (!$appointment) {
            return new JsonResponse(['message' => 'Appointment not found'], 404);
        }

        $appointment->setStatus('cancelled');

        $em->flush();

        return new JsonResponse(['message' => 'Appointment cancelled successfully']);
    }
}
