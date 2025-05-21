<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Repository\TreatmentRepository;
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
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['description'], $data['price'])) {
            return new JsonResponse(['error' => 'Faltan datos'], Response::HTTP_BAD_REQUEST);
        }

        $treatment = new Treatment();
        $treatment->setName($data['name']);
        $treatment->setDescription($data['description']);
        $treatment->setPrice($data['price']);

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Tratamiento creado correctamente'], Response::HTTP_CREATED);
    }

    #[Route('/api/getAllTreatments', name: 'list_treatments', methods: ['GET'])]
    public function list(TreatmentRepository $repository): JsonResponse
    {
        $treatments = $repository->findAll();

        $data = array_map(function (Treatment $treatment) {
            return [
                'id' => $treatment->getId(),
                'name' => $treatment->getName(),
                'description' => $treatment->getDescription(),
                'price' => $treatment->getPrice(),
            ];
        }, $treatments);

        return new JsonResponse($data, Response::HTTP_OK);
    }
/*
    #[Route('/{id}', name: 'get_treatment', methods: ['GET'])]
    public function getTreatment(int $id, TreatmentRepository $repository): JsonResponse
    {
        $treatment = $repository->find($id);

        if (!$treatment) {
            return new JsonResponse(['error' => 'Tratamiento no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $treatment->getId(),
            'name' => $treatment->getName(),
            'description' => $treatment->getDescription(),
            'price' => $treatment->getPrice(),
        ], Response::HTTP_OK);
    }

*/
    }
