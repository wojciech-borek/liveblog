<?php
declare(strict_types=1);

namespace App\Relation\Presentation\Action\Post;

use App\Relation\Application\Command\PostDelete\PostDeleteCommand;
use App\Relation\Domain\Exception\PostNotFoundException;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

#[OA\Tag('Posts')]
final readonly class DeletePostAction
{
    public function __construct(private MessageCommandBusInterface $messageBus, private SerializerInterface $serializer) {
    }

    #[Route('/api/posts/{id}', name: 'delete_post', methods: ['DELETE'])]
    #[OA\Delete(
        path: "/api/posts/{id}",
        operationId: "deletePost",
        summary: "Delete a post by ID",
        tags: ["Posts"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID of the post to delete",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Post was deleted successfully"),
            new OA\Response(response: 404, description: "Post not found"),
            new OA\Response(response: 422, description: "Invalid ID provided")
        ]
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $this->messageBus->dispatch(new PostDeleteCommand($id));
        } catch (PostNotFoundException $exception) {
            return JsonResponse::fromJsonString($this->serializer->serialize(
                ['error' => $exception->getMessage()], 'json'), $exception->getCode());
        }
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
