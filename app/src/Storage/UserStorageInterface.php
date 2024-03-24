<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\User;

interface UserStorageInterface
{
    public function store(User $user): void;
    public function getWithEmail(string $email): User;
}
