<?php
namespace Codeup\InteropMvc\Middleware\Stack\Server;

use Codeup\InteropMvc\Middleware\Stack\ResponseAware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Middleware\DelegateInterface;

class ResponseAwareArraySelfDelegate extends ArraySelfDelegate implements ResponseAware
{
    /**
     * @var null|DelegateInterface
     */
    protected $responseSourceDelegate = null;

    /**
     * @param \Psr\Http\Middleware\DelegateInterface $request
     * @return void
     */
    public function setResponseSourceDelegate(DelegateInterface $request)
    {
        $this->responseSourceDelegate = $request;
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
        if (!count($this->processingStack) && $this->responseSourceDelegate) {
            return $this->responseSourceDelegate->next($request);
        }
        return parent::next($request);
    }
}
