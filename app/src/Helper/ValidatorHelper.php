<?php

declare(strict_types=1);

namespace App\Helper;

final class ValidatorHelper
{
    private const EMAIL_MAX_LENGTH = 320;

    private const PASSWORD_MIN_LENGTH = 10;

    private const PASSWORD_MAX_LENGTH = 100;

    private static function isStringIfKeyExists($key, $data)
    {
        return empty($data[$key]) || is_string($data[$key]);
    }

    public static function isEmailValid(string $email): bool
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public static function isMinimumLengthValid(string $string, int $length): bool
    {
        return strlen($string) >= $length;
    }

    public static function isMaximumLengthValid(string $string, int $length): bool
    {
        return strlen($string) <= $length;
    }

    public static function validateCommon(array $data): array
    {
        $errors = [];

        if (false === self::isStringIfKeyExists('email', $data)
         || false === self::isStringIfKeyExists('password', $data)) {
            $errors['general'] = 'Oops! Something went wrong, please try again.';
        }

        if (true === empty($_POST['email']) || false === self::isEmailValid($data['email'])) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (false === self::isMaximumLengthValid($data['email'], self::EMAIL_MAX_LENGTH)) {
            $errors['email'] = 'Your email address is too long';
        }

        if (true === empty($_POST['password'])) {
            $errors['password'] = 'Please enter a password';
        }

        return $errors;
    }

    public static function validateRegister(array $data): array
    {
        $errors = self::validateCommon($data);

        if (false === isset($errors['password'])
         && false === self::isMinimumLengthValid($data['password'], self::PASSWORD_MIN_LENGTH)) {
            $errors['password'] = 'Your password must be at least ' . self::PASSWORD_MIN_LENGTH . ' characters';
        }

        if (false === isset($errors['password'])
         && false === self::isMaximumLengthValid($data['password'], self::PASSWORD_MAX_LENGTH)) {
            $errors['password'] = 'Your password must be less than ' . self::PASSWORD_MAX_LENGTH . ' characters';
        }

        return $errors;
    }

    public static function validateLogin(array $data): array
    {
        return self::validateCommon($data);
    }
}
