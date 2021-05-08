<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return $this->json(['status' => 'OK']);
    }
}
