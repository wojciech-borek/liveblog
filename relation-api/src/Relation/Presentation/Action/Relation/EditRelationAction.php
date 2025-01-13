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

final readonly class EditRelationAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/relations/{id}', name: 'edit_relation', methods: ['PUT'])]
    public function __invoke(string $id, Request $request): JsonResponse {
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