<?php

namespace Coozieki\Framework\Http\Response;

use Coozieki\Framework\Contracts\Http\Response;

/**
 * @codeCoverageIgnore
 */
class HtmlResponse implements Response
{
    public function __construct(private string $text)
    {
    }

    public function send(): void
    {
        echo $this->text;
    }
}
