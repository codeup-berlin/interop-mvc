<?php
namespace Codeup\InteropMvc\ServiceAware;

class InteropContainer implements \Codeup\InteropMvc\ServiceAware
{
    use InteropContainerTrait;

    /**
     * @param \Interop\Container\ContainerInterface $serviceContainer
     */
    public function __construct(\Interop\Container\ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }
}
