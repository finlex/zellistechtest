<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\User;
use App\Exception\UserNotFound;

final class TemporaryUserStorage implements UserStorageInterface
{
    private const TEMPORARY_STORAGE_LOCATION = __DIR__ . '/tmp/users.json';

    private array $cache = [];

    private array $emailLookup = [];

    public function __construct()
    {
        if (false === file_exists(self::TEMPORARY_STORAGE_LOCATION)) {
            $this->saveCache();
        }

        $this->loadCache();

        foreach ($this->cache as $id => $user) {
            $this->emailLookup[$user['email']] = $id;
        }
    }

    public function store(User $user): void
    {
        $this->cache[$user->id] = $user->toArray();
        $this->saveCache();
    }

    public function getWithEmail(string $email): User
    {
        if (false === isset($this->emailLookup[$email])) {
            throw new UserNotFound();
        }

        $data = $this->cache[$this->emailLookup[$email]];
        return User::fromArray($data);
    }

    private function saveCache(): void
    {
        file_put_contents(self::TEMPORARY_STORAGE_LOCATION, json_encode($this->cache));
    }

    private function loadCache(): void
    {
        $this->cache = json_decode(file_get_contents(self::TEMPORARY_STORAGE_LOCATION), true);
    }
}
