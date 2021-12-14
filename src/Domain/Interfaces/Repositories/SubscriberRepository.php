<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Subscriber;

interface SubscriberRepository
{
    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function create(Subscriber $subscriber): bool;

    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function edit(Subscriber $subscriber):bool;

    /**
     * @param int $id
     * @return Subscriber|null
     */
    public function getById(int $id): ?Subscriber;
}
