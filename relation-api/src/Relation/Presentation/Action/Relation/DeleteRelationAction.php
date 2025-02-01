<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Relations')]
final readonly class DeleteRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'delete_relation', methods: ['DELETE'])]
    #[OA\Delete(
        path: "/api/relations/{id}",
        operationId: "deleteRelation",
        summary: "Delete a relation by ID",
        tags: ["Relations"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID of the relation to delete",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Relation was deleted successfully"),
            new OA\Response(response: 404, description: "Relation not found"),
            new OA\Response(response: 422, description: "Invalid ID provided")
        ]
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $this->messageBus->dispatch(new RelationDeleteCommand($id));
        } catch (RelationNotFoundException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
