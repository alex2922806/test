<?php

namespace App\Service\Representation;

use Symfony\Component\HttpFoundation\Response;

interface EntityRepresentationInterface
{
    public function represent(array $data): Response;
}