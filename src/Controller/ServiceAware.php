<?php
namespace Codeup\InteropMvc\Controller;

use Codeup\InteropMvc\ServiceNotFoundException;

interface ServiceAware
{
    /**
     * @param string $serviceName
     * @return bool
     */
    public function hasService(string $serviceName): bool;

    /**
     * @param string $serviceName
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function getService(string $serviceName);
}
