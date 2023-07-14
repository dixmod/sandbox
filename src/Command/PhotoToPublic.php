<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\StoragePhoto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhotoToPublic extends Command
{
    private StoragePhoto $storagePhoto;

    public function __construct(StoragePhoto $storagePhoto)
    {
        parent::__construct();

        $this->storagePhoto = $storagePhoto;
    }

    protected function configure(): void
    {
    }

    protected static $defaultName = 'sandbox:photos-to-public';

    protected static $defaultDescription = 'Moving user photo to public folder by date';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->storagePhoto->getPrivatePhoto() as $photo) {
            $output->writeln(
                $photo->getFileName() . "\t" .
                $photo->getDateTimeOriginal()->format('Y-m-d')
            );
        }

        return Command::SUCCESS;
    }
}
