<?php
namespace Codeup\InteropMvc\Middleware;

use Codeup\InteropMvc\ServiceAware;
use Interop\Http\ServerMiddleware\MiddlewareInterface;

interface ServiceAwareServer extends MiddlewareInterface, ServiceAware
{
}
