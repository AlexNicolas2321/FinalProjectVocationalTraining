<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExerciseApiService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apiKey = 'h2809WhTfM0P4BmIFy/kzg==PjHsgWnGpaWBlEWg'; 
    }

    public function getCaloriesBurned(array $params): array
    {
        if (empty($params['activity'])) {
            throw new \InvalidArgumentException('El parámetro "activity" es requerido y no puede estar vacío.');
        }
    
        $query = [
            'activity' => $params['activity'],
        ];
    
        if (!empty($params['weight_kg'])) {
            $query['weight'] = $params['weight_kg'] * 2.20462;
        }
    
        if (!empty($params['duration_minutes'])) {
            $query['duration'] = $params['duration_minutes'];
        }
    
        $response = $this->client->request('GET', 'https://api.api-ninjas.com/v1/caloriesburned', [
            'headers' => [
                'X-Api-Key' => $this->apiKey,
            ],
            'query' => $query,
        ]);
    
        return $response->toArray();
    }
    

    
}
