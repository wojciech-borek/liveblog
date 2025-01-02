<?php

namespace App\FirebaseAuth\Presentation\Controller;

use App\FirebaseAuth\Application\Command\RegisterUser\RegisterUserCommand;
use App\FirebaseAuth\Domain\Exception\UserRegistrationException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: '')]
class Firebase extends AbstractController
{
    public function __construct(private readonly MessageCommandBusInterface $messageBus) {
    }

    #[Route('/auth/signup', name: 'signup', methods: ['POST'])]
    public function signup(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        try {
            $this->messageBus->dispatch(new RegisterUserCommand($data['email'], $data['password']));
            return $this->json(null, Response::HTTP_CREATED);
        } catch (UserRegistrationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
