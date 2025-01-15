<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Query\GetRelations\GetRelationsQuery;
use App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[OA\Tag('Relations')]
final readonly class GetRelationsAction
{
    public function __construct(private MessengerQueryBus $messengerQueryBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations', name: 'get_relations', methods: ['GET'])]
    #[OA\Get(
        path: "/api/relations",
        operationId: "getRelationsList",
        summary: "Get a list of relations",
        tags: ["Relations"],
        parameters: [
            new OA\Parameter(
                name: "page",
                description: "Page number",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "limit",
                description: "Number of relations per page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 10)
            ),
            new OA\Parameter(
                name: "filters",
                description: "Filters to apply on the relation list",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "array", items: new OA\Items(type: "string"))
            ),
            new OA\Parameter(
                name: "sortField",
                description: "Field to sort by",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "sortDirection",
                description: "Sort direction (asc or desc)",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "A list of relations",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "array",
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: "id", description: "Relation ID", type: "string"),
                                new OA\Property(property: "title", description: "Relation title", type: "string"),
                                new OA\Property(property: "status", description: "Relation status", type: "string")
                            ],
                            type: "object"
                        )
                    )
                )
            ),
            new OA\Response(response: 400, description: "Invalid query parameters"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $filters = $request->query->all('filters');
        $sortField = $request->query->get('sortField');
        $sortDirection = $request->query->get('sortDirection');
        $data = $this->messengerQueryBus->handle(new GetRelationsQuery($page, $limit, $filters, $sortField, $sortDirection));
        return JsonResponse::fromJsonString($this->serializer->serialize($data, 'json'));
    }
}
