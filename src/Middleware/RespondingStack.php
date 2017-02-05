<?php
namespace Codeup\InteropMvc\Middleware;

use Psr\Http\Middleware\DelegateInterface;

interface RespondingStack extends \Psr\Http\Middleware\StackInterface
{
    /**
     * @param \Psr\Http\Middleware\DelegateInterface $request
     * @return void
     */
    public function setResponseSourceDelegate(DelegateInterface $request);
}
