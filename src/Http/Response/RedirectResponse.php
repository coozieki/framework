<?php

namespace Coozieki\Framework\Http\Response;

use Coozieki\Framework\Contracts\Http\Response;

class RedirectResponse implements Response
{
    public function __construct(private string $location, private int $code = 301)
    {
    }

    public function send(): void
    {
        header("Location: $this->location", true, $this->code);
        die();
    }
}

