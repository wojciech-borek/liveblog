<?php

namespace App\Relation\Presentation\Controller;

use App\Relation\Application\Command\RelationCreate\RelationCreateCommand;
use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use App\Relation\Application\Query\GetRelations\GetRelationsQuery;
use App\Shared\Application\MessageCommandBusInterface;
use App\Shared\Domain\Exception\DomainException;
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

    #[Route('/relations', name: 'relation_index', methods: ['get'])]
    public function index(Request $request): JsonResponse {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $data = $this->messengerQueryBus->handle(new GetRelationsQuery($page, $limit));

        return $this->json($data);
    }


    #[Route('/relations', name: 'relation_create', methods: ['post'])]
    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        /**
         * @todo add validation
         */
        try {
            $this->messageBus->dispatch(new RelationCreateCommand(
                $data['title']
            ));
        } catch (DomainException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(null, Response::HTTP_ACCEPTED);
    }

    #[Route('/relations/{id}', name: 'relation_delete', methods: ['delete'])]
    public function delete(string $id): JsonResponse {
        try {
            $this->messageBus->dispatch(new RelationDeleteCommand($id));
        } catch (DomainException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(null, Response::HTTP_ACCEPTED);
    }

}
