<?php

namespace App\Service\Representation;

use App\Entity\Entity;
use App\Enum\RepresentationTypeEnum;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class EntityRepresentator
{
    public static function represent(array $entities, RepresentationTypeEnum $type): Response
    {
        /** @var EntityRepresentationInterface $representator */
        $representator = match ($type) {
            RepresentationTypeEnum::JSON => new JsonEntityRepresentation(),
            RepresentationTypeEnum::CSV => new CsvRepresentation(),
            RepresentationTypeEnum::YAML => new YamlRepresentation(),
            default => throw new RuntimeException('Not implemented representator')
        };

        $data = [];

        /** @var Entity $entity */
        foreach ($entities as $entity) {
            $data[] = [
                'title' => $entity->getTitle(),
                'description' => $entity->getDescription(),
                'author' => $entity->getAuthor(),
            ];
        }

        return $representator->represent($data);
    }
}