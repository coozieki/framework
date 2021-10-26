<?php

namespace App\Http;

use App\Contracts\Http\Response;
use App\Contracts\Http\ResponseFactory as ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    public function html(string $html): Response
    {
        return new HtmlResponse($html);
    }

    public function redirect(): Response
    {
        // TODO: Implement redirect() method.
    }
}
