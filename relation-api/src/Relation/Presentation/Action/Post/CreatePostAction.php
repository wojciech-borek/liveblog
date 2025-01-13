<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final readonly class CreatePostAction
{
    public function __construct(private MessageCommandBusInterface $messageBus) {
    }

    #[Route('/api/posts', name: 'create_post', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->messageBus->dispatch(new PostCreateCommand(
            $data['relationId'],
            $data['content'],
            $data['isPublished']
        ));
        return new JsonResponse(null,Response::HTTP_CREATED);
    }

}