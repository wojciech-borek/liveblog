<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Relation\Domain\Event\PostCreatedEvent;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostCreatedEventHandler
{
    public function __construct(private HubInterface $hub
    ) {
    }

    public function __invoke(PostCreatedEvent $event): void {
        $update = new Update(
            '/relation/' . $event->getRelationId(),
            json_encode([
                'postId' => $event->getId(),
            ])
        );

        $this->hub->publish($update);
    }
}
