<?php

declare(strict_types=1);

namespace App\Helper;

use App\Exception\UploadError;
use App\Repository\FileDataRepository;
use App\Repository\UserRepository;
use App\Storage\TemporaryFileDataStorage;
use App\Storage\TemporaryUserStorage;

final class UploadHelper
{
    public const UPLOAD_LOCATION = __DIR__ . '/../../uploads/';

    public static function processUploadedFile(string $userId): void
    {
        if (false === isset($_FILES['uploadedFile']) || $_FILES['uploadedFile']['error'] !== UPLOAD_ERR_OK) {
            throw new UploadError('An unexpected error occurred. Please try again!');
        }

        $path = $_FILES['uploadedFile']['tmp_name'];
        $name = $_FILES['uploadedFile']['name'];

        $dir = self::UPLOAD_LOCATION . $userId . '/';
        if (false === file_exists($dir)) {
            mkdir($dir);
        }

        $destination = $dir . $name;
        if (true === file_exists($destination)) {
            throw new UploadError('Sorry, a file with this name already exists');
        }

        if (false === move_uploaded_file($path, $destination)) {
            throw new UploadError('There was an error uploading the file. Please try again.');
        }
    }
}
