<?php

declare(strict_types=1);

namespace App\Component\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;

class BaseRepository extends ServiceEntityRepository
{
    /**
     * @throws EntityNotFoundException
     */
    public function get($id): object
    {
        $result = $this->find($id);

        if (null === $result) {
            throw EntityNotFoundException::fromClassNameAndIdentifier($this->getClassName(), [$id]);
        }

        return $result;
    }

    public function add($object): void
    {
        $this->isSupported($object);
        $this->getEntityManager()->persist($object);
    }

    public function save($object = null): void
    {
        null === $object ?: $this->add($object);
        $this->getEntityManager()->flush();
    }

    public function delete($entity): void
    {
        $this->isSupported($entity);
        $this->remove($entity);

        $this->getEntityManager()->flush($entity);
    }

    public function remove($entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    protected function isSupported($entity): void
    {
        $repositoryClass = $this->_class->rootEntityName;

        if (!($entity instanceof $repositoryClass)) {
            throw new InvalidEntityClassException($repositoryClass, \get_class($entity));
        }
    }
}
