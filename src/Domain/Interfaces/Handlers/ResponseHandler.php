<?php

namespace App\Domain\Interfaces\Handlers;

interface ResponseHandler
{
    public function responseOk():void;
    public function responseKo():void;
}