<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\PhotoInfoDto;
use App\Exception\DateTimeException;
use DateTimeImmutable;
use Exception;

class PhotoInfoFactory
{
    /**
     * @param array<string, string> $dataPhoto
     * @return PhotoInfoDto
     * @throws DateTimeException
     */
    static function create(array $dataPhoto): PhotoInfoDto
    {
        try {
            return new PhotoInfoDto(
                $dataPhoto['FileName'],
                new DateTimeImmutable($dataPhoto['DateTimeOriginal']
            ));
        } catch (Exception $exception) {
            throw new DateTimeException(DateTimeException::DEFAULT_MESSAGE, $exception);
        }
    }
}