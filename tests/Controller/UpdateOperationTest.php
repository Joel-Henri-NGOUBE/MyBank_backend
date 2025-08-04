<?php

namespace App\Tests\Controller;

use App\Entity\User;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UpdateOperationTest extends ApiTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $container = self::getContainer();

        $user = new User();
        $user->setEmail('this5@gmail.com');
        $user->setPassword(
            $container->get('security.user_password_hasher')->hashPassword($user, 'password')
        );
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        $response1 = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'this5@gmail.com',
                'password' => 'password', 
        ]]);

        $token = $response1->toArray()["token"];

        $response2 = $client->request('POST', '/api/id', [
            "headers" => [
                "Authorization" => "Bearer ". $token
            ],
            'json' => [
                'email' => 'this5@gmail.com',
            ]
            
        ]);

        $id = $response2->toArray()["id"];

        $response3 = $client->request('GET', "api/users/$id/operations", [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ]);

        $response4 = $client->request('POST', "/api/users/$id/operations", [
            'headers' => [
                'Content-Type' => 'application/json',
                "Authorization" => "Bearer $token"
            ],  
            "json" => [            
                "label" => "PAIEMENT DES TAXES FONCIERES SAS\nREF:FR2025:48:456355:34334:34",
                "amount" => 190.96,
                "type" => "EXPENSE",
                "category" => "TAX"
            ]
        ]);

        $response5 = $client->request('GET', "api/users/$id/operations", [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ]);

        $operation = $response5->toArray()["member"][0];

        self::assertEquals("PAIEMENT DES TAXES FONCIERES SAS\nREF:FR2025:48:456355:34334:34", $operation["label"]);

        $client->request('PATCH', "/api/users/$id/operations/" . $operation["id"], [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                "Authorization" => "Bearer $token"
            ],  
            "json" => [            
                "label" => "PAIEMENT DES TAXES FONCIERES",
            ]
        ]);

        $response6 = $client->request('GET', "api/users/$id/operations/" . $operation["id"], [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ])->toArray();

        self::assertEquals("PAIEMENT DES TAXES FONCIERES", $response6["label"]);


    }
}
