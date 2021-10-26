<?php

namespace App\Http\Response;

use App\Contracts\Http\Response;

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
