<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Payment;

interface PaymentRepository
{

    /**
     * @param Payment $payment
     * @return bool
     */
    public function create(Payment $payment): bool;

    /**
     * @param int $subscriberId
     * @return float
     */
    public function getTotalBySubscriberId(int $subscriberId): float;
}
