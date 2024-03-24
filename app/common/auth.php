<?php

declare(strict_types=1);

session_start();

if (false === isset($_SESSION['user'])) {
    header('Location: /login/');
}

