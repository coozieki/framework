<?php

namespace Coozieki\Framework\Http\Response;

use Coozieki\Framework\Contracts\Http\Response;

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
