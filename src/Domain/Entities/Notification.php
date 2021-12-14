<?php

namespace App\Domain\Entities;

class Notification
{
    const STATUS_ONLINE = 'ONLINE';
    const STATUS_DELETED = 'DELETED';

    const CACHE_NOTIFICATION_KEY = 'NOTIFICATION:CACHE';

    /** @var int  */
    private $subscriberId;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $status;

    /** @var string|null */
    private $subscribedAt;

    /** @var string|null */
    private $unsubscribedAt;

    /** @var string|null */
    private $transactionId;

    /** @var string|null */
    private $transactionDate;

    /** @var float|null */
    private $amount;

    /** @var string|null */
    private $result;

    public function __construct(
        int $subscriberId,
        ?string $email,
        ?string $status,
        ?string $subscribedAt,
        ?string $unsubscribedAt,
        ?int $transactionId,
        ?string $transactionDate,
        ?float $amount,
        ?string $result
    ) {
        $this->subscriberId    = $subscriberId;
        $this->email           = $email;
        $this->status          = $status;
        $this->subscribedAt    = $subscribedAt;
        $this->unsubscribedAt  = $unsubscribedAt;
        $this->transactionId   = $transactionId;
        $this->transactionDate = $transactionDate;
        $this->amount          = $amount;
        $this->result          = $result;
    }



    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getSubscribedAt(): ?string
    {
        return $this->subscribedAt;
    }

    public function getUnsubscribedAt(): ?string
    {
        return $this->unsubscribedAt;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getTransactionDate(): ?string
    {
        return $this->transactionDate;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function toArray(): array
    {
        return [
            'subscriber'        => $this->subscriberId,
            'email'             => $this->email,
            'status'            => $this->status,
            'subscribed_date'   => $this->subscribedAt,
            'unsubscribed_date' => $this->unsubscribedAt,
            'transaction_id'    => $this->transactionId,
            'transaction_date'  => $this->transactionDate,
            'amount'            => $this->amount,
            'result'            => $this->result
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
