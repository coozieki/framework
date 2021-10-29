<?php

namespace Coozieki\Framework\Http;

use Coozieki\Framework\Contracts\Http\Controller as ControllerInterface;
use Coozieki\Framework\Contracts\Http\Response;
use Coozieki\Framework\Contracts\Http\ResponseFactory;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Exceptions\MethodNotFoundException;

class Controller implements ControllerInterface
{
    private ResponseFactory $responseFactory;

    private Templator $templator;

    /**
     * @throws MethodNotFoundException
     */
    public function call(string $method): Response
    {
        if (!method_exists($this, $method)) {
            throw new MethodNotFoundException(sprintf('Method "%s" not found in "%s"', $method, static::class));
        }

        return $this->$method();
    }

    public function setResponseFactory(ResponseFactory $responseFactory): void
    {
        $this->responseFactory = $responseFactory;
    }

    public function setTemplator(Templator $templator): void
    {
        $this->templator = $templator;
    }

    /**
     * @throws ConfigurationException
     */
    protected function render(string $view, array $params = []): Response
    {
        if (empty($this->responseFactory)) {
            throw new ConfigurationException('ResponseFactory is not set.');
        }
        if (empty($this->templator)) {
            throw new ConfigurationException('Templator is not set.');
        }

        return $this->responseFactory->html($this->templator->render($view, $params));
    }
}
