<?php

namespace App\Controller;

use App\Service\ExerciseApiService;
use App\Service\NutritionApiService;
use App\Service\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServicesApiController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api/nutrition/{food}', name: 'app_nutrition' , methods:"GET")]
    public function getData(string $food, NutritionApiService $nutritionApiService, TranslationService $translation): Response
    {
        $translatedFood = $translation->translateToEnglish($food);

        $data = $nutritionApiService->getNutrition($translatedFood);

        return $this->json($data);
    }

    #[Route('/api/exercise', name: 'api_exercise', methods: ['POST'])]
public function getExerciseData(Request $request, ExerciseApiService $exerciseApi,TranslationService $translation): Response
{
    $data = json_decode($request->getContent(), true);



    if (
        !isset($data['activity']) || trim($data['activity']) === '' ||
        !isset($data['duration_minutes']) ||
        !isset($data['weight_kg'])
    ) {
        return $this->json(['error' => 'Faltan parámetros requeridos o están vacíos'], 400);
    }
    
    $data['activity'] = $translation->translateToEnglish($data['activity']);

    $calories = $exerciseApi->getCaloriesBurned($data);

    return $this->json([
        'calories' => $calories,
    ]);
}

}
