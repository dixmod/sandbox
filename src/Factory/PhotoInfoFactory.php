<?php

declare(strict_types=1);

use App\Dto\PhotoInfoDto;
use App\Exception\DateTimeException;

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
                new DateTimeImmutable($dataPhoto['DateTimeOriginal']
            ));
        } catch (Exception $exception) {
            throw new DateTimeException(DateTimeException::DEFAULT_MESSAGE, $exception);
        }
    }
}