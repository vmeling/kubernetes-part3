<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/users/{id}', name: 'user_update', methods: [Request::METHOD_PUT, Request::METHOD_PATCH])]
    public function index(string $id, Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($id);
        if ($user === null) {
            return $this->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $context = [AbstractNormalizer::OBJECT_TO_POPULATE => $user];
        $user = $this->serializer->deserialize($request->getContent(), User::class, JsonEncoder::FORMAT, $context);
        $errors = $this->validator->validate($user);
        if ($errors->count()) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $repository->flush();

            return $this->json($user);
        } catch (ORMException $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
