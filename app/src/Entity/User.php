<?php

declare(strict_types=1);

namespace App\Entity;

final class User
{
    private function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['email'],
            $data['password']
        );
    }
}
