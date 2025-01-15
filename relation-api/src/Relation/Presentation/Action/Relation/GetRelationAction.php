<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Query\GetOneRelation\GetOneRelationQuery;
use App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Relations')]
final readonly class GetRelationAction
{
    public function __construct(private MessengerQueryBus $messengerQueryBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'get_relation', methods: ['GET'])]
    #[OA\Get(
        path: "/api/relations/{id}",
        operationId: "getRelationById",
        summary: "Get a relation by ID",
        tags: ["Relations"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID of the relation to be fetched",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successfully retrieved relation",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "id", type: "string", description: "Relation ID"),
                            new OA\Property(property: "title", type: "string", description: "Relation title")
                        ],
                        type: "object"
                    )
                )
            ),
            new OA\Response(response: 404, description: "Relation not found"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(string $id): JsonResponse
    {
        $data = $this->messengerQueryBus->handle(new GetOneRelationQuery($id));
        return JsonResponse::fromJsonString($this->serializer->serialize($data, 'json'));
    }
}
