<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Relation;

use App\Relation\Application\Command\RelationChangeStatus\RelationChangeStatusCommand;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class ChangeStatusRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}/change_status', name: 'change_status_relation', methods: ['POST'])]
    public function __invoke(string $id, Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        try {
            $this->messageBus->dispatch(new RelationChangeStatusCommand($id, $data['status']));
        } catch (RelationNotFoundException|InvalidRelationStatusException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }
        return new JsonResponse();
    }
}