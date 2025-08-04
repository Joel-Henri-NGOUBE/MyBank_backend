<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpController extends AbstractController
{
    #[Route('signup', name: 'signup', methods: ["POST"])]
    public function signup(Request $request, EntityManagerInterface $em, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $payload = $request->getPayload()->all();

        $userExists = $userRepository->findOneByEmailField($payload["email"]);
        if($userExists){
            return $this->json([
                "code" => "401", 
                "message" => "An account with this email address already exists"
                ])
                ->setStatusCode(401);
        }
        $newUser = new User();
        $newUser->setEmail($payload["email"]);
        $hashedPassword = $passwordHasher->hashPassword(
            $newUser,
            $payload["password"]
        );
        $userRepository->upgradePassword($newUser, $hashedPassword);

        return $this->json([
            "code" => "200", 
            "message" => "User account created successfully"])
            ->setStatusCode(200);
    }

}
