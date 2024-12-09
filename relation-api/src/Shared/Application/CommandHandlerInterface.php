<?php

namespace App\Shared\Application;

interface CommandHandlerInterface
{
    public function handle(object $command): void;
}