<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class UserControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testIndex(): void
    {

        $client = static::createClient();

        $container = self::getContainer();

        // Creating an user
        $user = new User();
        $user->setEmail('this2@gmail.com');
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
                'email' => 'this2@gmail.com',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $json = $response1->toArray();
        $this->assertArrayHasKey('token', $json);

        // Getting his id to assert he has been created
        $response2 = $client->request('POST', '/api/id', [
            'headers' => [
                'Authorization' => 'Bearer ' . $json['token'],
            ],
            'json' => [
                'email' => 'this2@gmail.com',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $json2 = $response2->toArray();
        $this->assertArrayHasKey('id', $json2);
        $this->assertEquals($user->getId(), $json2['id']);

    }
}
