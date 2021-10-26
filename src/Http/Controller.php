<?php

namespace App\Http;

use App\Contracts\Http\Controller as ControllerInterface;
use App\Contracts\Http\Response;
use App\Contracts\Http\ResponseFactory;
use App\Exceptions\MethodNotFoundException;

class Controller implements ControllerInterface
{
    private ResponseFactory $responseFactory;

    protected string $viewPath = 'views/';

    /**
     * @throws MethodNotFoundException
     */
    public function call(ResponseFactory $responseFactory, string $method): Response
    {
        if (!method_exists($this, $method)) {
            throw new MethodNotFoundException(sprintf('Method "%s" not found in "%s"', $method, static::class));
        }

        $this->responseFactory = $responseFactory;

        return $this->$method();
    }

    protected function render(string $view, array $params = []): Response
    {
        extract($params, EXTR_OVERWRITE);

        ob_start();
        include $this->viewPath . $view . '.php';

        return $this->responseFactory->html(ob_get_clean());
    }
}
