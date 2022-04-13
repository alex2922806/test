<?php

namespace App\Controller;

use App\Entity\Entity;
use App\Enum\RepresentationTypeEnum;
use App\Repository\EntityRepository;
use App\Service\Representation\EntityRepresentator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EntityController extends AbstractController
{
    private EntityRepository $entityRepository;
    private ValidatorInterface $validator;

    public function __construct(EntityRepository $entityRepository, ValidatorInterface $validator)
    {
        $this->entityRepository = $entityRepository;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function create(Request $request): Response
    {
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $author = $request->request->get('author');

        $errors = $this->validator->validate([
            'title' => $title,
            'description' => $description,
            'author' => $author,
        ], new Collection([
            'title' => [
                new Type('string'),
                new NotBlank(),
                new Length(null, 2, 255)
            ],
            'description' => [
                new Type('string'),
                new NotBlank(),
                new Length(null, 2)
            ],
            'author' => [
                new Type('string'),
                new NotBlank(),
                new Length(null, 2, 255)
            ],
        ]));

        if (\count($errors) > 0) {
            // TODO throw exceptoion and handle it
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entity = new Entity($title, $description, $author,);

        $this->entityRepository->save($entity);

        return new RedirectResponse('/list');
    }

    public function list(): Response
    {
        $entities = $this->entityRepository->findAll();

        return $this->render('list.html.twig', ['entities' => $entities]);
    }

    public function download(Request $request): Response
    {
        $type = $request->query->get('type');

        $errors = $this->validator->validate([
            'type' => $type,
        ], new Collection([
            'type' => [
                new Type('string'),
                new NotBlank(),
                new Choice(['choices' => RepresentationTypeEnum::values()])
            ],
        ]));

        if (\count($errors) > 0) {
            // TODO throw exceptoion and handle it
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $representationType = RepresentationTypeEnum::from($type);

        $entities = $this->entityRepository->findAll();

        return EntityRepresentator::represent($entities, $representationType);
    }
}