<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api', name: 'api')]
class BoardController extends AbstractController
{
    // public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, HttpClientInterface $client) {
    //     $this->entityManager = $em;
    //     $this->serializer = SerializerBuilder::create()->build();
    //     $this->validator = $validator;
    //     $this->client = $client;
    // }

    // #[Route('/board', name: 'user.store', methods:['POST'])]
    // public function store(Request $request): JsonResponse
    // {
    //     $data = $request->toArray();

    //     $board = new Board();
    //     $user = $this->entityManager->getRepository(User::class)->findOneByUserId();
        
    //     $board->setName($data['name']);

        

    //     $board->setUser($data['user_id']);
    // }

}
