<?php

namespace App\Shared\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

readonly class ExceptionListener
{

    public function __construct(private KernelInterface $kernel) {
    }

    public function onKernelException(ExceptionEvent $event): void {
//        if ($this->kernel->getEnvironment() === 'dev') {
            $exception = $event->getThrowable();

            $response = new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception instanceof HttpExceptionInterface
                        ? $exception->getStatusCode()
                        : 500,
                    'trace' => $exception->getTraceAsString(),
                ],
                500
            );

            $event->setResponse($response);
            return;
//        }
//        $this->onKernelException($event);
    }
}