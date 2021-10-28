<?php

namespace Coozieki\Http;

use Coozieki\Contracts\Http\Response;
use Coozieki\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use Coozieki\Exceptions\NotImplementedException;
use Coozieki\Http\Response\HtmlResponse;
use Coozieki\Http\Response\NotFoundResponse;
use Coozieki\Http\Response\ServerErrorResponse;

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

    public function serverError(): Response
    {
        return new ServerErrorResponse();
    }

    public function notFound(): Response
    {
        return new NotFoundResponse();
    }
}
