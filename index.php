<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Logs\LogFileHandler;
use App\Infrastructure\Cache\CacheRedisHandler;
use App\Infrastructure\Http\ResponseHttpHandler;
use App\Infrastructure\Notification\NotificationS2sHandler;
use App\Infrastructure\Persistence\Mysql\PaymentPdoRepository;
use App\Infrastructure\Persistence\Mysql\SubscriberPdoRepository;

# config Settings
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

# dependencies
$logger = new LogFileHandler();
$notificationHandler = new NotificationS2sHandler();
$cacheHandler = new CacheRedisHandler();
$responseHandler = new ResponseHttpHandler();
$subscriberRepository = new SubscriberPdoRepository();
$paymentRepository = new PaymentPdoRepository();

# main threat
(new App\Application\NotificationManager(
    $logger,
    $notificationHandler,
    $responseHandler,
    $cacheHandler,
    $subscriberRepository,
    $paymentRepository
))->execute();
