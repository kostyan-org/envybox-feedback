<?php

namespace App\Store;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class StoreFactory implements StoreFactoryInterface
{
    private ParameterBagInterface $params;
    private Feedback $feedback;
    private FeedbackRepository $repository;
    private Filesystem $filesystem;

    private SerializerInterface $serializer;

    private array $enableStoreTypes;

    public function __construct(ParameterBagInterface $params,
                                FeedbackRepository $repository,
                                Filesystem $filesystem,
                                SerializerInterface $serializer)
    {
        $this->params = $params;
        $this->repository = $repository;
        $this->filesystem = $filesystem;
        $this->serializer = $serializer;
        $this->setEnableStoreTypes();
    }

    /**
     * @return array
     */
    public function getEnableStoreTypes(): array
    {
        return $this->enableStoreTypes;
    }

    /**
     * @return void
     */
    private function setEnableStoreTypes(): void
    {
        $this->enableStoreTypes = explode(',', $this->params->get('app.store.enable'));
    }

    /**
     * @return Feedback
     */
    public function getFeedback(): Feedback
    {
        return $this->feedback;
    }

    /**
     * @param Feedback $feedback
     */
    public function setFeedback(Feedback $feedback): void
    {
        $this->feedback = $feedback;
    }

    public function create(Feedback $feedback, string $type): StoreInterface
    {
        $this->setFeedback($feedback);
        if ($type === 'Mysql') {
            return new MysqlStore($this->repository);
        } elseif ($type === 'File') {
            return new FileStore($this->filesystem, $this->params, $this->serializer);
        }

        return new MysqlStore($this->repository);
    }

    public function save(array $stores): void
    {
        foreach ($stores as $store) {
            $store->save($this->getFeedback());
        }
    }
}