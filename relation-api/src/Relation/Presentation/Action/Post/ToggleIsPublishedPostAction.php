<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use App\Relation\Application\Command\PostToggleIsPublished\PostToggleIsPublishedCommand;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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