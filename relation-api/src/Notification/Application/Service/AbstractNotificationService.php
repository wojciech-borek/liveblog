<?php

namespace App\Notification\Application\Service;

use App\Notification\Application\Dto\NotificationDataDtoInterface;
use App\Notification\Application\NotificationTopic;
use App\Notification\Domain\Enum\NotificationType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

abstract class AbstractNotificationService
{
    public function __construct(private HubInterface $hub, private LoggerInterface $logger
    ) {
    }
    protected function publish(NotificationTopic $topic, NotificationType $type, NotificationDataDtoInterface $data): void {
        try {
            $update = new Update(
                $topic->getValue(),
                json_encode([
                    'type' => $type->value,
                    'data' => $data->toArray()
                ])
            );
            $id = $this->hub->publish($update);
            $this->logger->info('Publishing notification id: ' . $id, [
                'topic' => $topic->getValue(),
                'type' => $type->value,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            $this->logger->error('Failed to publish notification', [
                'error' => $e->getMessage(),
                'topic' => $topic->getValue(),
                'type' => $type->value
            ]);
        }

    }

}