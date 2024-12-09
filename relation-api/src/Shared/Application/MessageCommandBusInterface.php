<?php

namespace App\Shared\Application;

interface MessageCommandBusInterface
{
    public function dispatch(object $message): void;
}