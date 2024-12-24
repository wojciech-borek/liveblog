<?php

namespace App\Relation\Presentation\Controller;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\RelationCreate\RelationCreateCommand;
use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use App\Relation\Application\Command\RelationPublish\RelationPublishCommand;
use App\Relation\Application\Query\GetOneRelation\GetOneRelationQuery;
use App\Relation\Application\Query\GetRelations\GetRelationsQuery;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class RelationManagement extends AbstractController
{
    public function __construct(private readonly MessengerQueryBus $messengerQueryBus, private readonly MessageCommandBusInterface $messageBus) {
    }

    #[Route('/relations', name: 'relation_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $data = $this->messengerQueryBus->handle(new GetRelationsQuery($page, $limit));

        return $this->json($data);
    }

    #[Route('/relations/{id}', name: 'relation_detail', methods: ['GET'])]
    public function detail(string $id): JsonResponse {
        $data = $this->messengerQueryBus->handle(new GetOneRelationQuery($id));
        return $this->json($data);
    }


    #[Route('/relations', name: 'relation_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        try {
            $this->messageBus->dispatch(new RelationCreateCommand(
                $data['title']
            ));
        } catch (InvalidRelationStatusException|InvalidRelationTitleException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(null, Response::HTTP_CREATED);
    }

    #[Route('/relations/{id}/publish', name: 'relation_publish', methods: ['POST'])]
    public function publish(string $id): JsonResponse {
        try {
            $this->messageBus->dispatch(new RelationPublishCommand($id));
        } catch (RelationNotFoundException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
        return $this->json(null, Response::HTTP_OK);
    }

    #[Route('/relations/{id}', name: 'relation_delete', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse {
        try {
            $this->messageBus->dispatch(new RelationDeleteCommand($id));
        } catch (RelationNotFoundException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
        return $this->json(null, Response::HTTP_OK);
    }

    #[Route('/relations/{id}/create_post', name: 'relation_create_post', methods: ['POST'])]
    public function createPost(string $id, Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->messageBus->dispatch(new PostCreateCommand(
            $id,
            $data['content']
        ));
        return $this->json(null, Response::HTTP_CREATED);
    }

}
