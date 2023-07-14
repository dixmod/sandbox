<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PhotoInfoDto;
use App\Exception\DateTimeException;
use App\Exception\UnexpectedException;
use App\Factory\PhotoInfoFactory;
use Exception;

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
     * @return PhotoInfoDto[]
     */
    public function getUserPhoto(): iterable
    {
        foreach ($this->privatePath as $path) {
            foreach ($this->scanDir($path) as $photo) {
                yield $photo;
            }
        }

        return null;
    }

    /**
     * @param string $path
     * @return PhotoInfoDto[]
     */
    private function scanDir(string $path): iterable
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

            foreach ($this->scanDir($pathFile) as $photo) {
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
     * @param string $pathFile
     * @return PhotoInfoDto
     * @throws DateTimeException
     * @throws UnexpectedException
     */
    private function getPhotoInfo(string $pathFile): PhotoInfoDto
    {
        $infoPhoto = @exif_read_data($pathFile);

        if (false === $infoPhoto) {
            throw new UnexpectedException('Error photo info ' . $pathFile);
        }

        return PhotoInfoFactory::create($infoPhoto, $pathFile);
    }
}
