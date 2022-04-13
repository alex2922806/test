<?php

namespace App\Service\Representation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class JsonEntityRepresentation implements EntityRepresentationInterface
{
    public function represent(array $data): Response
    {
        return new JsonResponse($data);
    }
}