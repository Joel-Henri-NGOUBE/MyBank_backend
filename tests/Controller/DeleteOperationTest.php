<?php

namespace App\Tests\Controller;

use App\Entity\User;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class DeleteOperationTest extends ApiTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $container = self::getContainer();
        
        // Creating an user
        $user = new User();
        $user->setEmail('this6@gmail.com');
        $user->setPassword(
            $container->get('security.user_password_hasher')->hashPassword($user, 'password')
        );
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        // Authenticating him
        $response1 = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'this6@gmail.com',
                'password' => 'password', 
        ]]);

        $token = $response1->toArray()["token"];

        // Getting his id
        $response2 = $client->request('POST', '/api/id', [
            "headers" => [
                "Authorization" => "Bearer ". $token
            ],
            'json' => [
                'email' => 'this6@gmail.com',
            ]
            
        ]);
        $id = $response2->toArray()["id"];

        // Getting all his operations. At this levelo, there is no operation
        $response3 = $client->request('GET', "api/users/$id/operations", [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ]);

        self::assertCount(0, $response3->toArray()["member"]);

        // Creating an operation for the user
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

        // Getting all his operations. At this level, there is one operation
        $response5 = $client->request('GET', "api/users/$id/operations", [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ]);

        self::assertCount(1, $response5->toArray()["member"]);

        $operation = $response5->toArray()["member"][0];

        // Deleting the added operation
        $client->request('DELETE', "/api/users/$id/operations/" . $operation["id"], [
            'headers' => [
                'Content-Type' => 'application/json',
                "Authorization" => "Bearer $token"
            ]]);

        // Getting all his operations. At this level, there is no more operation
        $response6 = $client->request('GET', "api/users/$id/operations", [
            "headers" => [
                "Authorization" => "Bearer $token"
            ]
        ])->toArray();

        self::assertCount(0, $response6["member"]);



    }
}
