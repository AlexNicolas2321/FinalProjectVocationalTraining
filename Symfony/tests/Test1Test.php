<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class Test1Test extends WebTestCase
{
    private array $adminCredentials = [
        'dni' => '99999999A',
        'password' => '1234567',
    ];

    private function loginAndGetToken(KernelBrowser $client, array $credentials): string
    {
        $client->request(
            'POST',
            '/api/signIn',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($credentials)
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        return $data['token'] ?? '';
    }

    public function testListUsers(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $token = $this->loginAndGetToken($client, $this->adminCredentials);

        $client->request(
            'GET',
            '/api/getAllUsers',
            server: ['HTTP_Authorization' => "Bearer $token"]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }



    public function testCreateAdmin(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $token = $this->loginAndGetToken($client, $this->adminCredentials);

        $data = [
            'dni' => '99999249Z',
            'password' => 'testpassword',
            'roles' => [1], 
        ];

        $client->request(
            'POST',
            '/api/admin',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => "Bearer $token"
            ],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame(201);
    }

    public function testEditRoleUser(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $token = $this->loginAndGetToken($client, $this->adminCredentials);

        $data = [
            'id' => 2, 
            'role' => ['ROLE_RECEPTIONIST'],
        ];

        $client->request(
            'PATCH',
            '/api/editRoleUser',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => "Bearer $token"
            ],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame(200);
    }
}
