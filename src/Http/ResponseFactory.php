<?php

namespace App\Http;

use App\Contracts\Http\Response;
use App\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use App\Exceptions\NotImplementedException;
use App\Http\Response\HtmlResponse;
use App\Http\Response\NotFoundResponse;
use App\Http\Response\ServerErrorResponse;

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
