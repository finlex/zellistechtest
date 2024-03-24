<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Storage\UserStorageInterface;

final class UserRepository
{
    public function __construct(private UserStorageInterface $storage)
    {
    }

    public function create(User $user): void
    {
        $this->storage->store($user);
    }

    public function getWithEmail(string $email): User
    {
        return $this->storage->getWithEmail($email);
    }
}
