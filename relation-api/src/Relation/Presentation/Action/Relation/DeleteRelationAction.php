<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class DeleteRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'delete_relation', methods: ['DELETE'])]
    public function __invoke($id, Request $request): JsonResponse {
        try {
            $this->messageBus->dispatch(new RelationDeleteCommand($id));
        } catch (RelationNotFoundException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());

        }
        return new JsonResponse();
    }


}