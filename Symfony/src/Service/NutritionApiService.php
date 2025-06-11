<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NutritionApiService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->apiKey = 'h2809WhTfM0P4BmIFy/kzg==PjHsgWnGpaWBlEWg';
    }

    public function getNutrition(string $query): array
    {
        $response = $this->client->request('GET', 'https://api.api-ninjas.com/v1/nutrition', [
            'headers' => [
                'X-Api-Key' => $this->apiKey
            ],
            'query' => [
                'query' => $query
            ]
        ]);

        return $response->toArray();
    }
}
