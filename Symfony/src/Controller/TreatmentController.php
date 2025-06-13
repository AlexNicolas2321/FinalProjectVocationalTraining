<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Treatment;
use App\Repository\TreatmentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TreatmentController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/api/createTreatment', name: 'create_treatment', methods: ['POST'])]
    public function create(Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_DOCTOR');

        $data = json_decode($request->getContent(), true);
        $doctor = $entityManager->getRepository(Doctor::class)->find($data['doctorId'] ?? null);

        if (!isset($data['name'], $data['description'], $data['price'])) {
            return new JsonResponse(['error' => 'Faltan datos'], Response::HTTP_BAD_REQUEST);
        }

        $treatment = new Treatment();
        $treatment->setName($data['name']);
        $treatment->setDescription($data['description']);
        $treatment->setPrice($data['price']);
        $treatment->setDoctor($doctor);
        

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Tratamiento creado correctamente'], Response::HTTP_CREATED);
    }

    #[Route('/api/getAllTreatments', name: 'list_treatments', methods: ['GET'])]
    public function list(TreatmentRepository $repository): JsonResponse
    {

       
 
        $treatments = $repository->findAll();
       
        $data = array_map(function (Treatment $treatment) {
            $doctor = $treatment->getDoctor();

            return [
                'id' => $treatment->getId(),
                'name' => $treatment->getName(),
                'description' => $treatment->getDescription(),
                'price' => $treatment->getPrice(),
                'doctorId' => $doctor->getId(),
                'doctor_first_name'=> $doctor->getFirstName(),
                'doctor_last_name'=> $doctor->getLastName(),

            ];
        }, $treatments);

        return new JsonResponse($data, Response::HTTP_OK);
    }
    }
