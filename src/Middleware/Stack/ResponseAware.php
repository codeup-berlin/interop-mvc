<?php
namespace Codeup\InteropMvc\Middleware\Stack;

use Psr\Http\Middleware\DelegateInterface;

interface ResponseAware extends \Psr\Http\Middleware\StackInterface
{
    /**
     * @param \Psr\Http\Middleware\DelegateInterface $request
     * @return void
     */
    public function setResponseSourceDelegate(DelegateInterface $request);
}
