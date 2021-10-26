<?php

namespace App\Http;

use App\Contracts\Http\Response;

/**
 * @codeCoverageIgnore
 */
class NotFoundResponse implements Response
{
    public function send(): void
    {
        http_response_code(404);
    }
}
