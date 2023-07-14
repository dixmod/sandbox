<?php

declare(strict_types=1);

namespace App\Factory;

namespace App\Dto;

use DateTimeImmutable;

class PhotoInfoDto
{
    private string $fileName;
    private DateTimeImmutable $dateTimeOriginal;

    public function __construct(string $fileName, DateTimeImmutable $dateTimeOriginal)
    {
        $this->fileName = $fileName;
        $this->dateTimeOriginal = $dateTimeOriginal;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getDateTimeOriginal(): DateTimeImmutable
    {
        return $this->dateTimeOriginal;
    }
}
