<?php

declare(strict_types=1);

namespace App\Factory;

namespace App\Dto;

use DateTimeImmutable;

class PhotoInfoDto
{
    private DateTimeImmutable $dateTimeOriginal;

    public function __construct(DateTimeImmutable $dateTimeOriginal)
    {
        $this->dateTimeOriginal = $dateTimeOriginal;
    }

    public function getDateTimeOriginal(): DateTimeImmutable
    {
        return $this->dateTimeOriginal;
    }
}