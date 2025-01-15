<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use OpenApi\Attributes as OA;
use App\Relation\Application\Command\PostToggleIsPublished\PostToggleIsPublishedCommand;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(
    name: "Posts",
    description: "Operations related to posts"
)]
final readonly class ToggleIsPublishedPostAction
{
    public function __construct(private MessageCommandBusInterface $messageBus) {
    }

    #[OA\PathItem(
        path: "/api/posts/{id}/toggle_is_published_post"
    )]
    #[OA\Post(
        description: "Toggles the published status of a post with the provided ID.",
        summary: "Toggle post published status",
        tags: ["Posts"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "The ID of the post to toggle",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Post status toggled successfully",
                content: new OA\JsonContent(type: "null")
            ),
            new OA\Response(
                response: 400,
                description: "Invalid post ID"
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    #[Route('/api/posts/{id}/toggle_is_published_post', name: 'toggle_is_published_post', methods: ['POST'])]
    public function __invoke(string $id, Request $request): JsonResponse {
        $this->messageBus->dispatch(new PostToggleIsPublishedCommand($id));
        return new JsonResponse();
    }
}