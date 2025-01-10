<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Query\GetRelations\GetRelationsQuery;
use App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class GetRelationsAction
{
    public function __construct(private MessengerQueryBus $messengerQueryBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations', name: 'get_relations', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $filters = $request->query->all('filters');
        $sortField = $request->query->get('sortField');
        $sortDirection = $request->query->get('sortDirection');
        $data = $this->messengerQueryBus->handle(new GetRelationsQuery($page, $limit, $filters, $sortField, $sortDirection));
        return JsonResponse::fromJsonString($this->serializer->serialize($data, 'json'));
    }


}