<?php

namespace Coozieki\Framework\Http\Response;

use Coozieki\Framework\Contracts\Http\Response;

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
