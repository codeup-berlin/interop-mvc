<?php
namespace Codeup\InteropMvc\Middleware;

use Codeup\InteropMvc\ServiceAware;
use Psr\Http\Middleware\ServerMiddlewareInterface;

interface ServiceAwareServer extends ServerMiddlewareInterface, ServiceAware
{
}
