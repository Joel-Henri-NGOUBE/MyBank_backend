<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class UpdateOperationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testIndex(): void
    {
        $client = static::createClient();

        $container = self::getContainer();

        // Creating an user
        $user = new User();
        $user->setEmail('this5@gmail.com');
        $user->setPassword(
            $container->get('security.user_password_hasher')->hashPassword($user, 'password')
        );
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        // Authenticating him
        $response1 = $client->request('POST', '/api/login_check', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'this5@gmail.com',
                'password' => 'password',
            ],
        ]);

        $token = $response1->toArray()['token'];

        // Getting his id
        $response2 = $client->request('POST', '/api/id', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'email' => 'this5@gmail.com',
            ],
        ]);

        $id = $response2->toArray()['id'];

        // Getting all his operations. At this level, there is no operation
        $response3 = $client->request('GET', "api/users/{$id}/operations", [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        // Creating an operation for the user
        $response4 = $client->request('POST', "/api/users/{$id}/operations", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
            'json' => [
                'label' => 'PAIEMENT DES TAXES FONCIERES SAS\nREF:FR2025:48:456355:34334:34',
                'amount' => 190.96,
                'type' => 'EXPENSE',
                'category' => 'TAX',
            ],
        ]);

        // Getting all his operations. At this level, there is one operation
        $response5 = $client->request('GET', "api/users/{$id}/operations", [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        $operation = $response5->toArray()['member'][0];

        self::assertEquals('PAIEMENT DES TAXES FONCIERES SAS\nREF:FR2025:48:456355:34334:34', $operation['label']);

        // Modifying the added operation
        $client->request('PATCH', "/api/users/{$id}/operations/" . $operation['id'], [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                'Authorization' => "Bearer {$token}",
            ],
            'json' => [
                'label' => 'PAIEMENT DES TAXES FONCIERES',
            ],
        ]);

        // Verify that the operation has indeed been modified
        $response6 = $client->request('GET', "api/users/{$id}/operations/" . $operation['id'], [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
        ])->toArray();

        self::assertEquals('PAIEMENT DES TAXES FONCIERES', $response6['label']);

    }
}
