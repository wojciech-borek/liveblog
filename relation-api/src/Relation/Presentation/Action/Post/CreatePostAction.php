<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag('Posts')]
final readonly class CreatePostAction
{
    public function __construct(private MessageCommandBusInterface $messageBus) {
    }

    #[Route('/api/posts', name: 'create_post', methods: ['POST'])]
    #[OA\Post(
        path: "/api/posts",
        operationId: "createPost",
        summary: "Create a new post",
        requestBody: new OA\RequestBody(
            description: "Create a new post",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["relationId", "content", "isPublished"],
                    properties: [
                        new OA\Property(property: "relationId", description: "ID of the related item", type: "string", example: "12345"),
                        new OA\Property(property: "content", description: "Content of the post", type: "string", example: "This is a sample post."),
                        new OA\Property(property: "isPublished", description: "Whether the post is published", type: "boolean", example: true)
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Posts"],
        responses: [
            new OA\Response(response: 201, description: "Post created successfully"),
            new OA\Response(response: 400, description: "Invalid request data"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function __invoke(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->messageBus->dispatch(new PostCreateCommand(
            $data['relationId'],
            $data['content'],
            $data['isPublished'],
            !empty($data['temporaryId']) ? $data['temporaryId'] : null,
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
