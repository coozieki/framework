<?php

namespace App\Http;

use App\Contracts\Http\Response;

/**
 * @codeCoverageIgnore
 */
class ServerErrorResponse implements Response
{
    public function send(): void
    {
        http_response_code(500);
    }
}
