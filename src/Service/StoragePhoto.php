<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PhotoInfoDto;
use App\Exception\DateTimeException;
use App\Exception\UnexpectedException;
use App\Factory\PhotoInfoFactory;
use Exception;
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

    /**
     * @return Generator|PhotoInfoDto
     */
    public function getPrivatePhoto(): Generator
    {
        foreach ($this->privatePath as $path) {
            foreach ($this->scan($path) as $photo) {
                yield $photo;
            }
        }

        return null;
    }

    /**
     * @param string $path
     * @return Generator|PhotoInfoDto
     */
    private function scan(string $path): Generator
    {
        $subFiles = $this->getDirContent($path);

        foreach ($subFiles as $pathFile) {
            $pathFile = $path . DIRECTORY_SEPARATOR . $pathFile;

            if (is_file($pathFile) === true) {
                try {
                    yield $this->getPhotoInfo($pathFile);
                } catch (Exception $exception) {
                    // @todo loging
                }

                continue;
            }

            foreach ($this->scan($pathFile) as $photo) {
                yield $photo;
            }
        }

        return null;
    }

    /**
     * @param string $path
     * @return string[]
     */
    private function getDirContent(string $path): array
    {
        return array_diff(scandir($path), $this->exclusionDirName);
    }

    /**
     * @param string $file
     * @return PhotoInfoDto
     * @throws UnexpectedException
     * @throws DateTimeException
     */
    private function getPhotoInfo(string $file): PhotoInfoDto
    {
        $infoPhoto = @exif_read_data($file);
        if (false === $infoPhoto) {
            throw new UnexpectedException('Error photo info ' . $file);
        }

        return PhotoInfoFactory::create($infoPhoto);
    }
}
