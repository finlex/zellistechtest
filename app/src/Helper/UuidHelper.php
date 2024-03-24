<?php

declare(strict_types=1);

namespace App\Helper;

final class UuidHelper
{
    public static function v4(): string
    {
        // Quick immitation of UUID for proof of concept
        // Ideally use something like ramsey/uuid library
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
    }
}
