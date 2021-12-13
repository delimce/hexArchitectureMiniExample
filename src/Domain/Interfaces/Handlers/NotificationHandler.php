<?php

namespace App\Domain\Interfaces\Handlers;

use App\Domain\Entities\Notification;
use App\Domain\Entities\Payment;
use App\Domain\Entities\Subscriber;

interface NotificationHandler
{
    public function read(): ?Notification;
    public function isValid(?array $data): bool;
    public function isNewSubscriber(Notification $notification): bool;
    public function isDropSubscriber(Notification $notification): bool;
    public function isPayment(Notification $notification): bool;
    public function getSubscriber(Notification $notification): Subscriber;
    public function getPayment(Notification $notification): Payment;
    public function toJson(Notification $notification): string;
    public function toArray(Notification $notification): array;
}
