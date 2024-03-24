<?php

declare(strict_types=1);

namespace App\Helper;

use App\Entity\User;
use App\Exception\LoginFailed;
use App\Exception\UserNotFound;
use App\Repository\UserRepository;
use App\Storage\TemporaryUserStorage;

final class LoginHelper
{
    private readonly UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(
            new TemporaryUserStorage()
        );
    }

    public function attemptLogin(string $email, string $password): User
    {
        try {
            $user = $this->userRepository->getWithEmail($email);
        } catch (UserNotFound $e) {
            password_verify($password, 'abc');
            throw new LoginFailed();
        }

        if (false === password_verify($password, $user->password)) {
            throw new LoginFailed();
        }

        return $user;
    }
}
