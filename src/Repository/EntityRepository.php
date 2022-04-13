<?php

namespace App\Repository;

use App\Component\Repository\BaseRepository;
use App\Entity\Entity;
use Doctrine\Persistence\ManagerRegistry;

final class EntityRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}