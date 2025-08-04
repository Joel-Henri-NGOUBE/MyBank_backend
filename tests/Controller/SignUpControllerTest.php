<?php

namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class SignUpControllerTest extends ApiTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/signup', [
            'headers' => ['Content-Type' => 'application/json'],  
            "json" => [
                'email' => 'this1@gmail.com',
                'password' => 'password',    
            ]
        ]);
        // var_dump($response);

        self::assertResponseIsSuccessful();
    }
}
