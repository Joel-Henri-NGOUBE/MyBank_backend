<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

final class UserController extends AbstractController
{
    #[Route('/api/id', name: 'id', methods: ["POST"])]
    public function getId(Request $request, UserRepository $userRepository): Response
    {
        $payload = $request->getPayload()->all();
        return $this->json(["id" => $userRepository->findOneByEmailField($payload["email"])->getId()]);
    }
}
