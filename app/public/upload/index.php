<?php

declare(strict_types=1);

require(__DIR__ . '/../../common/autoload.php');
require(__DIR__ . '/../../common/auth.php');

use App\Exception\UploadError;
use App\Helper\UploadHelper;

if (false === empty($_POST) && isset($_POST['submit'])) {
    try {
        UploadHelper::processUploadedFile($_SESSION['user']);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'File uploaded successfully'
        ];
    } catch (UploadError $e) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
    }
}

header('Location: /');

?>