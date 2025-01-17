<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Relation\Domain\Event\PostDeletedEvent;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostDeletedEventHandler
{
    public function __construct(private HubInterface $hub
    ) {
    }

    public function __invoke(PostDeletedEvent $event): void {

        $update = new Update(
            '/relation/' . $event->getRelationId(),
            json_encode([
                'id' => $event->getId(),
            ])
        );
        $this->hub->publish($update);
    }
}
