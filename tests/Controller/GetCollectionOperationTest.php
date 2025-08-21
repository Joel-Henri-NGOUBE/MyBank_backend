<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Operations;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class GetCollectionOperationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testIndex(): void
    {
        $client = static::createClient();

        $container = self::getContainer();

        // Creating an user
        $user = new User();
        $user->setEmail('this4@gmail.com');
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
                'email' => 'this4@gmail.com',
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
                'email' => 'this4@gmail.com',
            ],
        ]);

        $id = $response2->toArray()['id'];

        // Getting all his operations. At this level, there is no operation
        $response3 = $client->request('GET', "api/users/{$id}/operations", [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        self::assertCount(0, $response3->toArray()['member']);

        // Creating 4 operations for the user
        $client->request('POST', "/api/users/{$id}/operations", [
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

        $client->request('POST', "/api/users/{$id}/operations", [
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

        $client->request('POST', "/api/users/{$id}/operations", [
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

        $client->request('POST', "/api/users/{$id}/operations", [
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

        // Getting all his operations. At this level, there are operations
        $response4 = $client->request('GET', "api/users/{$id}/operations", [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertCount(4, $response4->toArray()['member']);

    }
}
