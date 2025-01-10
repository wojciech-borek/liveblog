<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Query\GetOneRelation\GetOneRelationQuery;
use App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class GetRelationAction
{
    public function __construct(private MessengerQueryBus $messengerQueryBus,private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'get_relation', methods: ['GET'])]
    public function __invoke(string $id): JsonResponse {
        $data = $this->messengerQueryBus->handle(new GetOneRelationQuery($id));
        return JsonResponse::fromJsonString($this->serializer->serialize($data, 'json'));
    }


}