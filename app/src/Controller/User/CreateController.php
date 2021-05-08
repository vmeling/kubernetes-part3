<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/users', name: 'user_create', methods: [Request::METHOD_POST])]
    public function index(Request $request, UserRepository $repository): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, JsonEncoder::FORMAT);
        $errors = $this->validator->validate($user);
        if ($errors->count()) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $repository->createUser($user);

            return $this->json($user);
        } catch (ORMException $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
