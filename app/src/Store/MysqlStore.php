<?php

namespace App\Store;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;

class MysqlStore implements StoreInterface
{
    public FeedbackRepository $repository;
    public function __construct(FeedbackRepository $repository)
    {
        $this->repository = $repository;
    }
    public function save(Feedback $feedback): void
    {
        $this->repository->add($feedback, true);
    }
}