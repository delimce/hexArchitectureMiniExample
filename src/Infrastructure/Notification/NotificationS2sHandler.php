<?php

namespace App\Infrastructure\Notification;

use App\Domain\Entities\Notification;
use App\Domain\Entities\Payment;
use App\Domain\Entities\Subscriber;
use App\Domain\Interfaces\Handlers\NotificationHandler;

class NotificationS2sHandler implements NotificationHandler
{

    public function read(): ?Notification
    {
        $info = json_decode(file_get_contents('php://input'), true);
        $result = null;
        if ($info) {
            $result = new Notification(
                $info['subscriber'],
                $info['email'],
                $info['status'],
                $info['subscribed_date'],
                $info['unsubscribed_date'],
                $info['transaction_id'],
                $info['transaction_date'],
                $info['amount'],
                $info['result']
            );
        }
        return $result;
    }

    public function isNewSubscriber(Notification $notification): bool
    {
        return $notification->getSubscriberId() && $notification->getSubscribedAt()
            && $notification->getEmail();
    }

    public function isDropSubscriber(Notification $notification): bool
    {
        return $notification->getSubscriberId() && $notification->getUnsubscribedAt();
    }

    public function isPayment(Notification $notification): bool
    {
        return $notification->getTransactionId() && $notification->getSubscriberId()
            && $notification->getTransactionDate() && $notification->getAmount() && $notification->getResult();
    }


    public function getSubscriber(Notification $notification): Subscriber
    {
        return new Subscriber(
            $notification->getSubscriberId(),
            $notification->getEmail(),
            $notification->getStatus(),
            $notification->getSubscribedAt(),
            $notification->getUnsubscribedAt()
        );
    }

    function getPayment(Notification $notification): Payment
    {
        return new Payment(
            null,
            $notification->getSubscriberId(),
            $notification->getTransactionId(),
            $notification->getTransactionDate(),
            $notification->getAmount(),
            $notification->getResult()
        );
    }
}
