<?php

namespace App\Domain\Entities;

class Payment
{
    /** @var int*/
    private $id;

    /** @var int*/
    private $subscriberId;

    /** @var string*/
    private $transactionId;

    /** @var string*/
    private $transactionDate;

    /** @var float*/
    private $amount;

    /** @var string*/
    private $result;

    public function __construct(
        ?int $id,
        int $subscriberId,
        int $transactionId,
        string $transactionDate,
        float $amount,
        string $result
    ) {
        $this->id              = $id;
        $this->subscriberId    = $subscriberId;
        $this->transactionId   = $transactionId;
        $this->transactionDate = $transactionDate;
        $this->amount          = $amount;
        $this->result          = $result;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }

    public function setSubscriberId(int $subscriberId)
    {
        $this->subscriberId = $subscriberId;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function setTransactionId(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }

    public function setTransactionDate(string $transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result)
    {
        $this->result = $result;
    }
}
