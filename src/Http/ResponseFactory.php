<?php

namespace Coozieki\Framework\Http;

use Coozieki\Framework\Contracts\Http\Response;
use Coozieki\Framework\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use Coozieki\Framework\Exceptions\NotImplementedException;
use Coozieki\Framework\Http\Response\HtmlResponse;
use Coozieki\Framework\Http\Response\NotFoundResponse;
use Coozieki\Framework\Http\Response\ServerErrorResponse;

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
