<?php

namespace App\Infrastructure\Logs;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Domain\Interfaces\Handlers\LogHandler;

class LogFileHandler implements LogHandler
{

    private $logger;

    public function __construct()
    {
        $this->logger = new Logger('logger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/notification.log', Logger::INFO));
    }


    public function info(string $msg, array $data = [])
    {
        $this->logger->info($msg, $data);
    }

    public function error(string $msg, array $data = [])
    {
        $this->logger->error($msg, $data);
    }
}
