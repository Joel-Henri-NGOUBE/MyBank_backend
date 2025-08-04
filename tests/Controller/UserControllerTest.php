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
        // (new SignUpControllerTest())->testIndex();

        $client = static::createClient();

        $container = self::getContainer();

        $user = new User();
        $user->setEmail('this2@gmail.com');
        // echo($user->getEmail());
        $user->setPassword(
            $container->get('security.user_password_hasher')->hashPassword($user, 'password')
        );
        // var_dump($user, 1);
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();
        // var_dump($user, 2);
        
        $response1 = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'this2@gmail.com',
                'password' => 'password', 
                ]]);
                
        // var_dump($user, 3);
        // var_dump($json);
        // echo($user->getEmail());
        // echo($user->getId());
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
            
        // var_dump($user, 4);
        $this->assertResponseIsSuccessful();
        $json2 = $response2->toArray();
        // var_dump($json2);
        $this->assertArrayHasKey('id', $json2);
        // echo($user->getId());
        $this->assertEquals($user->getId(), $json2["id"]);
        
        // self::assertResponseIsSuccessful();
    }
}
