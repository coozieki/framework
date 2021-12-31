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
     * @throws ConfigurationException
     */
    public function call(string $method): Response
    {
        if (!method_exists($this, $method)) {
            throw new MethodNotFoundException(sprintf('Method "%s" not found in "%s"', $method, static::class));
        }
        $this->checkConfiguration();
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

    protected function render(string $view, array $params = []): Response
    {
        return $this->responseFactory->html($this->templator->render($view, $params));
    }

    protected function json(mixed $data): Response
    {
        return $this->responseFactory->json($data);
    }

    protected function redirect(string $location, int $code = 301): Response
    {
        return $this->responseFactory->redirect($location, $code);
    }

    /**
     * @throws ConfigurationException
     */
    private function checkConfiguration(): void
    {
        if (empty($this->responseFactory)) {
            throw new ConfigurationException('ResponseFactory is not set.');
        }
        if (empty($this->templator)) {
            throw new ConfigurationException('Templator is not set.');
        }
    }
}
