<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class PhotoToPublic extends Command
{
    protected function configure(): void
    {
    }

    protected static $defaultName = 'sandbox:photos-to-public';

    protected static $defaultDescription = 'Moving user photo  to public folder';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            foreach (self::PRIVATE_PATH as $path) {
                $this->scan($path);
            }
        } catch (Exception $exception) {
            return Command::FAILURE;

        }

        return Command::SUCCESS;
    }

    private function scan(string $path)
    {
        $subDirs = $this->getDirContent($path);

        foreach ($subDirs as $subDir) {
            $file = $path . '/' . $subDir;

            if (is_file($file) === true) {
                $this->parsePhoto($file);

                continue;
            }

            $this->scan($file);
        }
    }

    /**
     * @param string $path
     * @return string[]
     */
    private function getDirContent(string $path): array
    {
        return array_diff(
            scandir($path),
            self::EXCLUSION_DIR_NAME
        );
    }

    private function parsePhoto(string $file)
    {
        try {
            $infoPhoto = @exif_read_data($file);
        }catch (Exception $exception){

        }

        echo $infoPhoto['DateTimeOriginal']. PHP_EOL;
        exit();
    }

//    private function convertTo
}

