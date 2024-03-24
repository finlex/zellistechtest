<?php

declare(strict_types=1);

namespace App\Helper;

use App\Entity\User;
use App\Exception\EmailAlreadyExists;
use App\Exception\UserNotFound;
use App\Repository\UserRepository;
use App\Storage\TemporaryUserStorage;

final class RegisterHelper
{
    private const HASHING_ALGO = PASSWORD_BCRYPT;

    private readonly UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(
            new TemporaryUserStorage()
        );
    }

    public function registerUser(string $email, string $password): User
    {
        try {
            $this->userRepository->getWithEmail($email);
            throw new EmailAlreadyExists();
        } catch (UserNotFound $e) {
        }

        $hashed = password_hash($password, self::HASHING_ALGO);
        $user = User::fromArray([
            'id' => UuidHelper::v4(),
            'email' => $email,
            'password' => $hashed
        ]);

        $this->userRepository->create($user);
        return $user;
    }
}
