<?php

namespace App\FirebaseAuth\Presentation\Action;

use App\FirebaseAuth\Application\Command\RegisterUser\RegisterUserCommand;
use App\FirebaseAuth\Domain\Exception\UserRegistrationException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

readonly class SignupAction
{
    public function __construct(private MessageCommandBusInterface $messageBus,private SerializerInterface $serializer) {
    }

    #[Route('/api/auth/signup', name: 'signup', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        try {
            $this->messageBus->dispatch(new RegisterUserCommand($data['email'], $data['password']));
            return new JsonResponse(null, Response::HTTP_CREATED);
        } catch (UserRegistrationException $e) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $e->getMessage()], 'json'), $e->getCode());
        }
    }
}