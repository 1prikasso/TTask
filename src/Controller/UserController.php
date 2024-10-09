<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use JMS\Serializer\SerializerBuilder;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


#[Route('api', name: 'api')]
class UserController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, HttpClientInterface $client) {
        $this->entityManager = $em;
        $this->serializer = SerializerBuilder::create()->build();
        $this->validator = $validator;
        $this->client = $client;
    }

    #[Route('/user', name: 'user.store', methods:['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $user = new User();

        $user->setName($data['name']);
        $user->setUsername($data['username']);
        $user->setUserId($data['user_id']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($this->serializer->serialize($user, 'json'), Response::HTTP_OK);
    }

    #[Route('/user', name: 'user.idnex', methods:['GET'])]
    public function index() {
        $users = $this->enityManager->getRepository(User::class)->find();

        return new JsonResponse($this->serializer->serialize($users, 'json'), Response::HTTP_OK);
    }

    #[Route('/user', name: 'user.update', methods:['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $repo = $this->entityManager->getRepository(User::class);
        $user = $repo->findOneByUserId($data['user_id']);

        $user->setEmail($data['email']);
        
        $query = [
            'email' => $data['email'],
            "key" => "ff4ad57a7089071b5b941f1b86a1d599",
            "token" => "ATTA018834f49a57295187d882e73b7bf26dd625921f7c5964b3fccf214eaf2abb702B5F0A25"
        ];
        
        // invite to board
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $this->client->request('PUT', 'https://api.trello.com/1/boards/6705e704bebd374c8d270433/members', [
            'query' => $query
        ]);
        
        return new JsonResponse($this->serializer->serialize($user, 'json'), Response::HTTP_OK);
    }
}
