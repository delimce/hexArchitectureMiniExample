<?php

namespace App\Infrastructure\Http;

use App\Domain\Interfaces\Handlers\ResponseHandler;

class ResponseHttpHandler implements ResponseHandler
{
    /**
     * Everything ok :)
     * @return void
     */
    public function responseOk(): void
    {
        http_response_code(200);
    }

    /**
     * Error response for notification
     * @return void
     */
    public function responseKo(): void
    {
        http_response_code(409);
    }
}
