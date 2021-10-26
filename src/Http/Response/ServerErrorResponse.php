<?php

namespace App\Http\Response;

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
