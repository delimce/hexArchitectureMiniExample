<?php

namespace App\Application;

use App\Domain\Entities\Subscriber;
use App\Domain\Entities\Notification;
use App\Domain\Interfaces\Handlers\LogHandler;
use App\Domain\Interfaces\Handlers\CacheHandler;
use App\Domain\Interfaces\Handlers\ResponseHandler;
use App\Domain\Interfaces\Handlers\NotificationHandler;
use App\Domain\Interfaces\Repositories\PaymentRepository;
use App\Domain\Interfaces\Repositories\SubscriberRepository;

class NotificationManager
{

    /** @var LogHandler $logger */
    private $logHandler;

    /** @var NotificationHandler $notificationHandler */
    private $notificationHandler;

    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    /** @var CacheHandler $cacheHandler */
    private $cacheHandler;

    /** @var SubscriberRepository $subscriberRepository */
    private $subscriberRepository;

    /** @var PaymentRepository $paymentRepository */
    private $paymentRepository;

    public function __construct(
        LogHandler           $logger,
        NotificationHandler  $notificationHandler,
        ResponseHandler      $responseHandler,
        CacheHandler         $cacheHandler,
        SubscriberRepository $subscriberRepository,
        PaymentRepository    $paymentRepository
    ) {
        $this->logHandler           = $logger;
        $this->notificationHandler  = $notificationHandler;
        $this->responseHandler      = $responseHandler;
        $this->cacheHandler         = $cacheHandler;
        $this->subscriberRepository = $subscriberRepository;
        $this->paymentRepository    = $paymentRepository;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $notification = $this->notificationHandler->read();
        if (!$this->isNotificationInProcess($notification)) {
            $this->processNotification($notification);
        }
    }

    /**
     * @param Notification|null $notification
     * @return void
     */
    protected function processNotification(?Notification $notification)
    {
        # save trace original notification
        $originalNotification = $notification->toArray();
        $this->logHandler->info("notification received", $originalNotification);

        if ($this->notificationHandler->isNewSubscriber($notification)) {
            $subscriber = $this->notificationHandler->getSubscriber($notification);
            $this->processNewSubscriber($subscriber);
        } else if ($this->notificationHandler->isDropSubscriber($notification)) {
            $subscriber = $this->notificationHandler->getSubscriber($notification);
            $this->processDropSubscriber($subscriber);
        } else if ($this->notificationHandler->isPayment($notification)) {
            $this->processPayment($notification);
        } else {
            $this->logHandler->error("Unknown notification error", $originalNotification);
            $this->responseHandler->responseKo();
        }
    }

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    protected function processNewSubscriber(Subscriber $subscriber)
    {
        if ($this->subscriberRepository->create($subscriber)) {
            $this->logHandler->info("Subscriber created", $subscriber->toArray());
            $this->responseHandler->responseOk();
        } else {
            $this->logHandler->error("Error creating subscriber", $subscriber->toArray());
            $this->responseHandler->responseKo();
        }
    }

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    protected function processDropSubscriber(Subscriber $subscriber)
    {

        $currentSubscriber = $this->subscriberRepository->getById($subscriber->getId());
        if ($currentSubscriber && $currentSubscriber->getStatus() === Notification::STATUS_ONLINE) {
            $currentSubscriber->setStatus(Notification::STATUS_DELETED);
            $currentSubscriber->setUnsubscribedAt($subscriber->getUnsubscribedAt());

            $this->subscriberRepository->edit($currentSubscriber);
            $this->logHandler->info("Subscriber drop has been done", $currentSubscriber->toArray());
            $this->responseHandler->responseOk();
        } else {
            $this->logHandler->error("Error subscriber is not valid for drop up", $subscriber->toArray());
            $this->responseHandler->responseKo();
        }
    }

    /**
     * @param Notification $notification
     * @return void
     */
    protected function processPayment(Notification $notification)
    {
        $payment = $this->notificationHandler->getPayment($notification);
        $subscriber = $this->subscriberRepository->getById($payment->getSubscriberId());
        if ($subscriber && $this->paymentRepository->create($payment)) {
            $total = $this->paymentRepository->getTotalBySubscriberId($subscriber->getId());
            $subscriber->setTotal($total);
            $this->subscriberRepository->edit($subscriber);
            $this->logHandler->info("Payment has been processed", $payment->toArray());
            $this->responseHandler->responseOk();
        } else {
            $this->logHandler->error("Error processing payment", $payment->toArray());
            $this->responseHandler->responseKo();
        }
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isNotificationInProcess(Notification $notification): bool
    {
        $serializedNotification = $notification->toJson();
        $notificationInProcess = $this->cacheHandler->getValue(Notification::CACHE_NOTIFICATION_KEY);

        if (strcasecmp($serializedNotification, $notificationInProcess) === 0) {
            $this->logHandler->error("Error notification duplicated or in process", $notification->toArray());
            $this->responseHandler->responseKo();
            return true;
        }
        $this->cacheHandler->setValue(Notification::CACHE_NOTIFICATION_KEY, $serializedNotification);
        return false;
    }
}
