<?php

namespace App\Relation\Presentation\Controller;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\PostToggleIsPublished\PostToggleIsPublishedCommand;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_posts')]
class PostManagement extends AbstractController
{
    public function __construct(private readonly MessageCommandBusInterface $messageBus) {
    }


    #[Route('/posts', name: 'create_post', methods: ['POST'])]
    public function createPost(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->messageBus->dispatch(new PostCreateCommand(
            $data['relationId'],
            $data['content'],
            $data['isPublished']
        ));
        return $this->json(null, Response::HTTP_CREATED);
    }

    #[Route('/posts/{id}/toggle_is_published_post', name: 'post_toggle_is_published', methods: ['POST'])]
    public function toggleIsPublishedPost(string $id): JsonResponse {
        $this->messageBus->dispatch(new PostToggleIsPublishedCommand($id));
        return $this->json(null, Response::HTTP_OK);
    }

}
