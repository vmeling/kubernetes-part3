<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RetrieveController extends AbstractController
{
    #[Route('/users/{id}', name: 'user_retrieve', methods: [Request::METHOD_GET])]
    public function index(string $id, UserRepository $repository): JsonResponse
    {
        $user = $repository->find($id);
        if ($user === null) {
            return $this->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($user);
    }
}
