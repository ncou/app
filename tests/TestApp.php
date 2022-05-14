<?php

declare(strict_types=1);

namespace Tests;

use Chiron\Application;

class TestApp extends Application
{
    public function get(string $entity): mixed
    {
        return $this->services->container->get($entity);
    }

    public function boot(): void
    {
        $this->services->boot();
    }
}
