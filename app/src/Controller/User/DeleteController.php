<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/users/{id}', name: 'user_delete', methods: [Request::METHOD_DELETE])]
    public function index(string $id, UserRepository $repository): Response
    {
        try {
            $repository->deleteUser($id);

            return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
        } catch (EntityNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (ORMException $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
