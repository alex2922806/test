<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

final class Entity
{
    private string $id;
    private string $title;
    private string $description;
    private string $author;

    public function __construct(string $title, string $description, string $author)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}