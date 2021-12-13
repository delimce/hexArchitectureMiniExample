<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Subscriber;

interface SubscriberRepository
{

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function create(Subscriber $subscriber);

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function edit(Subscriber $subscriber);
 
}