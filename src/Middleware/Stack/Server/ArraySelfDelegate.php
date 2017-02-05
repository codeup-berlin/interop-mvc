<?php
namespace Codeup\InteropMvc\Middleware\Stack\Server;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Middleware\DelegateInterface;
use Psr\Http\Middleware\MiddlewareInterface;
use Psr\Http\Middleware\ServerMiddlewareInterface;

class ArraySelfDelegate implements \Psr\Http\Middleware\StackInterface, DelegateInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $middlewares = [];

    /**
     * @var MiddlewareInterface[]
     */
    protected $processingStack = null;

    /**
     * Return an instance with the specified middleware added to the stack.
     * This method MUST be implemented in such a way as to retain the
     * immutability of the stack, and MUST return an instance that contains
     * the specified middleware.
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function withMiddleware(MiddlewareInterface $middleware)
    {
        if (!($middleware instanceof ServerMiddlewareInterface)) {
            throw new \InvalidArgumentException('ServerMiddlewareInterface request expected.');
        }

        foreach ($this->middlewares as $m) {
            if ($m === $middleware) {
                return $this;
            }
        }
        $this->middlewares[] = $middleware;
        // breaking **** immutability by intention ^^~>
        return $this;
    }

    /**
     * Return an instance without the specified middleware.
     * This method MUST be implemented in such a way as to retain the
     * immutability of the stack, and MUST return an instance that does not
     * contain the specified middleware.
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function withoutMiddleware(MiddlewareInterface $middleware)
    {
        if (!($middleware instanceof ServerMiddlewareInterface)) {
            throw new \InvalidArgumentException('ServerMiddlewareInterface request expected.');
        }

        foreach ($this->middlewares as $k => $m) {
            if ($m === $middleware) {
                unset($this->middlewares[$k]);
                break;
            }
        }
        // breaking **** immutability by intention ^^~>
        return $this;
    }

    /**
     * Process the request through middleware and return the response.
     * This method MUST be implemented in such a way as to allow the same
     * stack to be reused for processing multiple requests in sequence.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function process(RequestInterface $request)
    {
        if ($this->processingStack !== null) {
            throw new \RuntimeException('Middleware stack is already processing.');
        }
        if (!count($this->middlewares)) {
            throw new \RuntimeException('Middleware stack is empty.');
        }
        if (!($request instanceof ServerRequestInterface)) {
            throw new \InvalidArgumentException('ServerRequest request expected.');
        }
        $this->processingStack = array_reverse($this->middlewares);
        /** @var ServerMiddlewareInterface $middleware */
        $middleware = array_shift($this->processingStack);
        return $middleware->process($request, $this);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function next(RequestInterface $request)
    {
        if (!count($this->processingStack)) {
            throw new \RuntimeException('No middleware response created for stack.');
        }
        if (!($request instanceof ServerRequestInterface)) {
            throw new \InvalidArgumentException();
        }
        /** @var ServerMiddlewareInterface $middleware */
        $middleware = array_shift($this->processingStack);
        return $middleware->process($request, $this);
    }
}
