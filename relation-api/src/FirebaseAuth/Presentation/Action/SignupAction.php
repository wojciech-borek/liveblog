<?php
declare(strict_types=1);

namespace App\FirebaseAuth\Presentation\Action;

use App\FirebaseAuth\Application\Command\RegisterUser\RegisterUserCommand;
use App\FirebaseAuth\Domain\Exception\UserRegistrationException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Authentication')]
final readonly class SignupAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/auth/signup', name: 'signup', methods: ['POST'])]
    #[OA\Post(
        path: "/api/auth/signup",
        operationId: "userSignup",
        summary: "User registration (sign up)",
        requestBody: new OA\RequestBody(
            description: "User registration data",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["email", "password"],
                    properties: [
                        new OA\Property(property: "email", description: "User's email", type: "string", example: "user@example.com"),
                        new OA\Property(property: "password", description: "User's password", type: "string", example: "password123")
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Authentication"],
        responses: [
            new OA\Response(response: 201, description: "User created successfully"),
            new OA\Response(response: 400, description: "Invalid request data"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
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
