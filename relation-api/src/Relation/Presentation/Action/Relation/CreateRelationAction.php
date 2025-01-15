<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationCreate\RelationCreateCommand;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Relations')]
final readonly class CreateRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations', name: 'create_relation', methods: ['POST'])]
    #[OA\Post(
        path: "/api/relations",
        operationId: "createRelation",
        summary: "Create a new relation",
        requestBody: new OA\RequestBody(
            description: "Relation data",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["title"],
                    properties: [
                        new OA\Property(property: "title", description: "Title of the relation", type: "string")
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Relations"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Relation created successfully",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "id", description: "Relation ID", type: "string"),
                            new OA\Property(property: "title", description: "Relation title", type: "string")
                        ],
                        type: "object"
                    )
                )
            ),
            new OA\Response(response: 400, description: "Invalid request data"),
            new OA\Response(response: 404, description: "Relation not found"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->messageBus->dispatch(new RelationCreateCommand($data['title']));
        } catch (InvalidRelationStatusException|InvalidRelationTitleException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
