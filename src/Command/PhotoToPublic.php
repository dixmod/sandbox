<?php

declare(strict_types=1);

namespace App\Command;

use App\Domain\PhotosToPublic\PathPhotoGenerator;
use App\Service\StoragePhoto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class PhotoToPublic extends Command
{
    protected static $defaultName = 'sandbox:photos-to-public';
    protected static $defaultDescription = 'Moving user photo to public folder by date';

    private StoragePhoto $storagePhoto;
    private PathPhotoGenerator $pathPhotoGenerator;

    public function __construct(StoragePhoto $storagePhoto, PathPhotoGenerator $pathPhotoGenerator)
    {
        parent::__construct();

        $this->storagePhoto = $storagePhoto;
        $this->pathPhotoGenerator = $pathPhotoGenerator;
    }

    protected function configure(): void
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->storagePhoto->getUserPhoto() as $photo) {
//            $output->writeln(
//                $photo->getFileName() . "\t" .
//                $this->pathPhotoGenerator->generator($photo)
//            );

            $this->storagePhoto->move($photo, $this->pathPhotoGenerator->generator($photo));
        }

        return Command::SUCCESS;
    }
}
