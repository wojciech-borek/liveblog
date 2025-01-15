<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationChangeStatus\RelationChangeStatusCommand;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Relations')]
final readonly class ChangeStatusRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}/change_status', name: 'change_status_relation', methods: ['POST'])]
    #[OA\Post(
        path: "/api/relations/{id}/change_status",
        operationId: "changeRelationStatus",
        summary: "Change the status of a relation",
        requestBody: new OA\RequestBody(
            description: "Status change data",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["status"],
                    properties: [
                        new OA\Property(property: "status", type: "string", description: "New status of the relation")
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Relations"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID of the relation to be updated",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Status changed successfully",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "id", description: "Relation ID", type: "string"),
                            new OA\Property(property: "status", description: "Updated status", type: "string")
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
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $this->messageBus->dispatch(new RelationChangeStatusCommand($id, $data['status']));
        } catch (RelationNotFoundException|InvalidRelationStatusException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }
        return new JsonResponse(null, Response::HTTP_OK);
    }
}
