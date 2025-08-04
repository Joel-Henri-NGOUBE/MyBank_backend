<?php

namespace App\Tests\Controller;

use App\Entity\User;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Controller\SignUpController;

final class UserControllerTest extends ApiTestCase
{
    public function testIndex(): void
    {

        $client = static::createClient();

        $container = self::getContainer();

        $user = new User();
        $user->setEmail('this2@gmail.com');
        $user->setPassword(
            $container->get('security.user_password_hasher')->hashPassword($user, 'password')
        );
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();
        
        $response1 = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'this2@gmail.com',
                'password' => 'password', 
                ]]);
                
        $this->assertResponseIsSuccessful();
        $json = $response1->toArray();
        $this->assertArrayHasKey('token', $json);
        
        $response2 = $client->request('POST', '/api/id', [
            "headers" => [
                "Authorization" => "Bearer ". $json["token"]
            ],
            'json' => [
                'email' => 'this2@gmail.com',
                ]
                
        ]);
            
        $this->assertResponseIsSuccessful();
        $json2 = $response2->toArray();
        $this->assertArrayHasKey('id', $json2);
        $this->assertEquals($user->getId(), $json2["id"]);
        
    }
}
