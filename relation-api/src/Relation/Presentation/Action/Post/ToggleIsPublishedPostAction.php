<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\PostToggleIsPublished\PostToggleIsPublishedCommand;
use App\Relation\Application\Command\RelationCreate\RelationCreateCommand;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class ToggleIsPublishedPostAction
{
    public function __construct(private MessageCommandBusInterface $messageBus) {
    }

    #[Route('/api/posts/{id}/toggle_is_published_post', name: 'toggle_is_published_post', methods: ['POST'])]
    public function __invoke(string $id, Request $request): JsonResponse {
        $this->messageBus->dispatch(new PostToggleIsPublishedCommand($id));
        return new JsonResponse();
    }

}