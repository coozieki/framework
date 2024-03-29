<?php

namespace Coozieki\Framework\Http\Response;

use Coozieki\Framework\Contracts\Http\Response;
use JsonException;

/**
 * @codeCoverageIgnore
 */
class JsonResponse implements Response
{
    public function __construct(private mixed $data)
    {
    }

    /**
     * @throws JsonException
     */
    public function send(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
