<?php

namespace App\Http;

use App\Contracts\Http\Response;
use App\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use App\Exceptions\NotImplementedException;

class ResponseFactory implements ResponseFactoryInterface
{
    public function html(string $html): Response
    {
        return new HtmlResponse($html);
    }

    /**
     * @throws NotImplementedException
     */
    public function redirect(): Response
    {
        throw new NotImplementedException();
    }
}
