<?php

namespace App\Domain\Interfaces\Handlers;

interface LogHandler
{
    public function info(string $msg, array $data = []);
    public function error(string $msg, array $data = []);
}
