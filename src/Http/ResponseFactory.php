<?php

namespace Coozieki\Framework\Http;

use Coozieki\Framework\Contracts\Http\Response;
use Coozieki\Framework\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use Coozieki\Framework\Exceptions\NotImplementedException;
use Coozieki\Framework\Http\Response\HtmlResponse;
use Coozieki\Framework\Http\Response\JsonResponse;
use Coozieki\Framework\Http\Response\NotFoundResponse;
use Coozieki\Framework\Http\Response\RedirectResponse;
use Coozieki\Framework\Http\Response\ServerErrorResponse;

class ResponseFactory implements ResponseFactoryInterface
{
    public function html(string $html): HtmlResponse
    {
        return new HtmlResponse($html);
    }

    public function json(mixed $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    public function redirect(string $location, ?int $code = 301): Response
    {
        return new RedirectResponse($location, $code);
    }

    public function serverError(): ServerErrorResponse
    {
        return new ServerErrorResponse();
    }

    public function notFound(): NotFoundResponse
    {
        return new NotFoundResponse();
    }
}
