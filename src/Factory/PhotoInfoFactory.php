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
     * @param string $pathFile
     * @return PhotoInfoDto
     * @throws DateTimeException
     */
    public static function create(array $dataPhoto, string $pathFile): PhotoInfoDto
    {
        try {
            return new PhotoInfoDto(
                $dataPhoto['FileName'],
                $pathFile,
                new DateTimeImmutable($dataPhoto['DateTimeOriginal'])
            );
        } catch (Exception $exception) {
            throw new DateTimeException(DateTimeException::DEFAULT_MESSAGE, $exception);
        }
    }
}
