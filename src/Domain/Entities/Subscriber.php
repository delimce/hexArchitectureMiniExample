<?php

namespace App\Domain\Entities;

class Subscriber
{
    /** @var int  */
    private $id;

    /** @var string */
    private $email;

    /** @var string */
    private $status;

    /** @var double|null */
    private $total;

    /** @var string|null */
    private $subscribedAt;

    /** @var string|null */
    private $unsubscribedAt;

    public function __construct(
        int $id,
        string $email,
        string $status,
        ?string $subscribedAt,
        ?string $unsubscribedAt
    ) {
        $this->id             = $id;
        $this->email          = $email;
        $this->status         = $status;
        $this->subscribedAt   = $subscribedAt;
        $this->unsubscribedAt = $unsubscribedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total)
    {
        $this->total = $total;
    }

    public function getSubscribedAt(): ?string
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(?string $subscribedAt)
    {
        $this->subscribedAt = $subscribedAt;
    }

    public function getUnsubscribedAt(): ?string
    {
        return $this->unsubscribedAt;
    }

    public function setUnsubscribedAt(?string $unsubscribedAt)
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'total' => $this->getTotal(),
            "status" => $this->getStatus(),
            "subscribedAt" => $this->getSubscribedAt(),
            "unsubscribedAt" => $this->getUnsubscribedAt()
        ];
    }
}
