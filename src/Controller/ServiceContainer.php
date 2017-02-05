<?php
namespace Codeup\InteropMvc\Controller;

use Codeup\InteropMvc\ServiceNotFoundException;

class ServiceContainer implements ServiceAware
{
    /**
     * @var null|\Interop\Container\ContainerInterface
     */
    private $serviceContainer = null;

    /**
     * @param \Interop\Container\ContainerInterface $serviceContainer
     */
    public function setServiceContainer(\Interop\Container\ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param string $serviceName
     * @return bool
     */
    public function hasService(string $serviceName): bool
    {
        return $this->serviceContainer ? $this->serviceContainer->has($serviceName) : false;
    }

    /**
     * @param string $serviceName
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function getService(string $serviceName)
    {
        if ($this->serviceContainer) {
            try {
                return $this->serviceContainer->get($serviceName);
            } catch (\Interop\Container\Exception\NotFoundException $e) {
                $this->throwException($serviceName, 'Service not found in container.');
            }
        }
        $this->throwException($serviceName, 'No service container set.');
    }

    /**
     * @param string $serviceName
     * @param string $reason
     * @param null|\Exception $previous
     * @throws ServiceNotFoundException
     */
    private function throwException(string $serviceName, string $reason, \Exception $previous = null)
    {
        $exception = new ServiceNotFoundException('Service "' . $serviceName . '" not found.' . $reason, 0, $previous);
        $exception->setServiceName($serviceName);
        throw $exception;
    }
}
