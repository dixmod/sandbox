<?php

declare(strict_types=1);

namespace App\Domain\PhotosToPublic;

use App\Dto\PhotoInfoDto;

/**
 *
 */
class PathPhotoGenerator
{
    private const FORMAT = 'Y.m.d';

    /**
     * @param PhotoInfoDto $photo
     * @return string
     */
    public function generator(PhotoInfoDto $photo): string
    {
        return $photo->getDateTimeOriginal()->format(self::FORMAT);
    }
}
