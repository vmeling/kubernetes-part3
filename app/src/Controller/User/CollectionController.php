<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    #[Route('/users', name: 'user_collection', methods: [Request::METHOD_GET])]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->json($users);
    }
}
