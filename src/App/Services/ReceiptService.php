<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
    public function validateFile(?array $file): void
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(["receipt" => ["No file uploaded"]]);
        }

        $maxFileSizeMB = 3 * 1024 * 1024;

        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException(["receipt" => ["File is too large"]]);
        }

        $originalFileName = $file["name"];


        if (!preg_match('/^[A-za-z0-9\s._-]+$/', $originalFileName)) {
            throw new ValidationException(["receipt" => ["File name is not valid"]]);
        }

        $clientMimeType = $file["type"];
        $allowedMimeTypes = ["image/jpeg", "image/png", "application/pdf"];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException(["receipt" => ["File type is not allowed"]]);
        }
    }


    public function upload(array $file): void
    {
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;

        $uploadPath = Paths::UPLOADS . "/" . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new ValidationException(["receipt" => ["Failed to upload file"]]);
        }
    }
}
