<?php

namespace App\Store;

use App\Entity\Feedback;


interface StoreFactoryInterface
{
    const NAMESPACE = 'App\Store';
    const SUFFIX = 'Store';

    /**
     * @param Feedback $feedback
     * @param string $type
     * @return StoreInterface
     */
    public function create(Feedback $feedback, string $type): StoreInterface;

    /**
     * @param StoreInterface[] $stores
     * @return void
     */
    public function save(array $stores): void;
}