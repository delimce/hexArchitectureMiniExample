<?php

namespace App\Infrastructure\Persistence\Mysql;

use App\Domain\Entities\Payment;
use App\Domain\Interfaces\Repositories\PaymentRepository;

class PaymentPdoRepository extends PdoAbstractRepository implements PaymentRepository
{

    /**
     * @param Payment $payment
     * @return bool
     */
    public function create(Payment $payment): bool
    {
        $data = [
            'subscriberId'    => $payment->getSubscriberId(),
            'transactionId'   => $payment->getTransactionId(),
            'transactionDate' => $payment->getTransactionDate(),
            'amount'          => $payment->getAmount(),
            'result'          => $payment->getResult(),
        ];
        $sql = "INSERT INTO payment (subscriber_id, transaction_id, transaction_date, amount, result)
                VALUES (:subscriberId, :transactionId, :transactionDate, :amount, :result)";
        return $this->executeSQL($sql, $data);
    }

    /**
     * @param int $subscriberId
     * @return float
     */
    public function getTotalBySubscriberId(int $subscriberId): float
    {
        $sql = "SELECT sum(amount) as total from payment WHERE subscriber_id = :id";
        $result = $this->query($sql, ['id' => $subscriberId]);
        return (float) $result["total"];
    }
}
