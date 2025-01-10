<?php
declare(strict_types=1);

namespace App\Shared\Application;

interface MessageCommandBusInterface
{
    public function dispatch(object $message): void;
}