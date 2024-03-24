<?php

declare(strict_types=1);

namespace App\Entity;

final class User
{
    private function __construct(
        private readonly string $id,
        private readonly string $userId,
        private readonly string $filename,
    ) {
    }
}
