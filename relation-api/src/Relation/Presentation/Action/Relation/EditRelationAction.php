<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationEdit\RelationEditCommand;
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
final readonly class EditRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'edit_relation', methods: ['PUT'])]
    #[OA\Put(
        path: "/api/relations/{id}",
        operationId: "editRelation",
        summary: "Edit an existing relation",
        requestBody: new OA\RequestBody(
            description: "Edit relation data",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["title"],
                    properties: [
                        new OA\Property(property: "title", description: "Title of the relation", type: "string", example: "Sample Relation Title")
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Relations"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID of the relation to be edited",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Relation edited successfully"),
            new OA\Response(response: 400, description: "Invalid request data"),
            new OA\Response(response: 404, description: "Relation not found"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->messageBus->dispatch(new RelationEditCommand(
                $id,
                $data['title']
            ));
        } catch (InvalidRelationStatusException|InvalidRelationTitleException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
