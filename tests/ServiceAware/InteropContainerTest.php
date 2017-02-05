<?php
namespace Codeup\InteropMvc\ServiceAware;

class ContainerItemNotFoundException extends \Exception implements \Interop\Container\Exception\NotFoundException
{
}

class InteropContainerTraitConsumer
{
    use InteropContainerTrait;
}

class InteropContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function hasService_withoutContainer()
    {
        $classUnderTest = new InteropContainerTraitConsumer();
        $this->assertFalse($classUnderTest->hasService(uniqid('someService')));
    }

    /**
     * @test
     */
    public function hasService_withoutService()
    {
        $serviceName = uniqid('someService');
        $containerMock = $this->createMock(\Interop\Container\ContainerInterface::class);
        $containerMock->expects($this->once())->method('has')->with($serviceName)->willReturn(false);
        /** @var \Interop\Container\ContainerInterface $containerMock */
        $classUnderTest = new InteropContainer($containerMock);
        $this->assertFalse($classUnderTest->hasService($serviceName));
    }

    /**
     * @test
     */
    public function hasService_withService()
    {
        $serviceName = uniqid('someService');
        $containerMock = $this->createMock(\Interop\Container\ContainerInterface::class);
        $containerMock->expects($this->once())->method('has')->with($serviceName)->willReturn(true);
        /** @var \Interop\Container\ContainerInterface $containerMock */
        $classUnderTest = new InteropContainerTraitConsumer();
        $classUnderTest->setServiceContainer($containerMock);
        $this->assertTrue($classUnderTest->hasService($serviceName));
    }

    /**
     * @test
     * @expectedException \Codeup\InteropMvc\ServiceNotFoundException
     */
    public function getService_withoutContainer()
    {
        $classUnderTest = new InteropContainerTraitConsumer();
        $classUnderTest->getService(uniqid('someService'));
    }

    /**
     * @test
     * @expectedException \Codeup\InteropMvc\ServiceNotFoundException
     */
    public function getService_withoutService()
    {
        $serviceName = uniqid('someService');
        $containerMock = $this->createMock(\Interop\Container\ContainerInterface::class);
        $containerMock->expects($this->once())->method('get')->with($serviceName)->willThrowException(
            new ContainerItemNotFoundException()
        );
        /** @var \Interop\Container\ContainerInterface $containerMock */
        $classUnderTest = new InteropContainer($containerMock);
        $classUnderTest->getService($serviceName);
    }

    /**
     * @test
     */
    public function getService_withService()
    {
        $serviceName = uniqid('someService');
        $serviceStub = new \stdClass();
        $containerMock = $this->createMock(\Interop\Container\ContainerInterface::class);
        $containerMock->expects($this->once())->method('get')->with($serviceName)->willReturn($serviceStub);
        /** @var \Interop\Container\ContainerInterface $containerMock */
        $classUnderTest = new InteropContainerTraitConsumer();
        $classUnderTest->setServiceContainer($containerMock);
        $this->assertSame($serviceStub, $classUnderTest->getService($serviceName));
    }
}
