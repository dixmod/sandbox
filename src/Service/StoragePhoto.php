<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PhotoInfoDto;
use App\Exception\DateTimeException;
use App\Factory\PhotoInfoFactory;
use Generator;

class StoragePhoto
{
    private array $privatePath;
    private string $publicPath;
    private array $exclusionDirName;

    public function __construct(array $privatePath, string $publicPath, array $exclusionDirName)
    {
        $this->privatePath = $privatePath;
        $this->publicPath = $publicPath;
        $this->exclusionDirName = $exclusionDirName;
    }

    public function getPrivatePhoto(): Generator
    {
        foreach ($this->privatePath as $path) {
            return $this->scan($path);
        }
    }

    private function scan(string $path): Generator
    {
        $subFiles = $this->getDirContent($path);

        foreach ($subFiles as $pathFile) {
            $pathFile = $path . DIRECTORY_SEPARATOR . $pathFile;

            if (is_file($pathFile) === true) {
                yield $this->parsePhoto($pathFile);

                continue;
            }

            //yield $this->scan($pathFile);
        }
    }

    private function getDirContent(string $path): array
    {
        return array_diff(scandir($path), $this->exclusionDirName);
    }

    private function parsePhoto(string $file): PhotoInfoDto
    {
        try {
            $infoPhoto = @exif_read_data($file);
            return PhotoInfoFactory::create($infoPhoto);
        } catch (DateTimeException $exception) {

        }
    }
}