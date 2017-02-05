<?php
namespace Codeup\InteropMvc;

class ServiceNotFoundException extends \LogicException
{
    /**
     * @var string
     */
    private $serviceName = '';

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     */
    public function setServiceName(string $serviceName)
    {
        $this->serviceName = $serviceName;
    }
}
