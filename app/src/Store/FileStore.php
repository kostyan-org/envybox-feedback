<?php

namespace App\Store;

use App\Entity\Feedback;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class FileStore implements StoreInterface
{
    private Filesystem $filesystem;
    private ParameterBagInterface $params;
    private SerializerInterface $serializer;
    const FOLDER_FILES = 'files';
    public function __construct(Filesystem $filesystem,
                                ParameterBagInterface $params,
                                SerializerInterface $serializer)
    {
        $this->filesystem = $filesystem;
        $this->params = $params;
        $this->serializer = $serializer;
    }

    public function save(Feedback $feedback): void
    {
        $filename = static::FOLDER_FILES . '/' . $this->params->get('app.store.filename') . '.txt';

        $jsonString = $this->serializer->serialize($feedback, 'json');

        $this->filesystem->mkdir(static::FOLDER_FILES);
        $this->filesystem->appendToFile($filename, $jsonString);
    }
}