<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\EventListener;

use App\Shared\Domain\Exception\DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

readonly class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event) {
        $exception = $event->getThrowable();
        $response = $this->createErrorResponse($exception);


        $event->setResponse($response);
    }


    private function createErrorResponse(\Throwable $exception): JsonResponse {
        if ($exception instanceof HandlerFailedException) {
            $originalException = $exception->getPrevious();
            if ($originalException instanceof DomainException) {
                return new JsonResponse([
                    'error' => $originalException->getMessage(),
                    'status' => $originalException->getCode(),
                ], $originalException->getCode());
            }
        }
        return new JsonResponse([
            'error' => 'Internal server error',
            'details' => $exception->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);


    }
}