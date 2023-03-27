<?php
namespace App\Store;
use App\Entity\Feedback;

interface StoreInterface
{
    public function save(Feedback $feedback): void;
}