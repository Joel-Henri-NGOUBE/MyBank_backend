<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class SignUpControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testIndex(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/signup', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'this1@gmail.com',
                'password' => 'password',
            ],
        ]);

        self::assertResponseIsSuccessful();
    }
}
