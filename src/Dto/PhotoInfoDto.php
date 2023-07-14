<?php

declare(strict_types=1);

namespace App\Factory;

namespace App\Dto;

use DateTimeImmutable;

class PhotoInfoDto
{
    private string $fileName;
    private string $path;
    private DateTimeImmutable $dateTimeOriginal;

    public function __construct(string $fileName, string $path, DateTimeImmutable $dateTimeOriginal)
    {
        $this->fileName = $fileName;
        $this->path = $path;
        $this->dateTimeOriginal = $dateTimeOriginal;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDateTimeOriginal(): DateTimeImmutable
    {
        return $this->dateTimeOriginal;
    }
}
