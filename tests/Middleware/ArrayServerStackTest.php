<?php
namespace Codeup\InteropMvc\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Middleware\DelegateInterface;

class MiddlewareFake implements \Psr\Http\Middleware\ServerMiddlewareInterface
{
    /**
     * Process a server request and return a response.
     * Takes the incoming request and optionally modifies it before delegating
     * to the next frame to get a response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $frame
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $frame
    ) {
        return $frame->next($request);
    }
}

class ArrayServerStackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function process_withSingleMiddleware()
    {
        // prepare
        /** @var \Psr\Http\Message\RequestInterface $requestStub */
        $requestStub = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        /** @var \Psr\Http\Message\ResponseInterface $responseStub */
        $responseStub = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $classUnderTest = new ArrayServerStack();
        $finalMiddlewareStub = $this->createMock(\Psr\Http\Middleware\ServerMiddlewareInterface::class);
        $finalMiddlewareStub->method('process')
            ->with($requestStub, $classUnderTest)
            ->willReturn($responseStub);
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $finalMiddlewareStub */
        $classUnderTest = $classUnderTest->withMiddleware($finalMiddlewareStub);
        // test
        $result = $classUnderTest->process($requestStub);
        // verify
        $this->assertSame($responseStub, $result);
    }

    /**
     * @test
     * @expectedException \RuntimeException empty
     */
    public function process_withoutMiddleware()
    {
        // prepare
        /** @var \Psr\Http\Message\RequestInterface $requestStub */
        $requestStub = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        $classUnderTest = new ArrayServerStack();
        // test
        $classUnderTest->process($requestStub);
        // verified by annotation
    }

    /**
     * @test
     */
    public function process_withMultipleMiddlewares()
    {
        // prepare
        /** @var \Psr\Http\Message\RequestInterface $requestStub */
        $requestStub = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        /** @var \Psr\Http\Message\ResponseInterface $responseStub */
        $responseStub = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $classUnderTest = new ArrayServerStack();
        $middlewareFake1 = new MiddlewareFake();
        $middlewareFake2 = new MiddlewareFake();
        $finalMiddlewareStub = $this->createMock(\Psr\Http\Middleware\ServerMiddlewareInterface::class);
        $finalMiddlewareStub
            ->expects($this->once())
            ->method('process')
            ->with($requestStub, $classUnderTest)
            ->willReturn($responseStub);
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $finalMiddlewareStub */
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $middlewareFake2 */
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $middlewareFake1 */
        /** @var ArrayServerStack $classUnderTest */
        $classUnderTest = $classUnderTest->withMiddleware($finalMiddlewareStub);
        $classUnderTest = $classUnderTest->withMiddleware($middlewareFake2);
        $classUnderTest = $classUnderTest->withMiddleware($middlewareFake1);
        // test
        $result = $classUnderTest->process($requestStub);
        // verify
        $this->assertSame($responseStub, $result);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function process_withMultipleMiddlewaresWithoutResponse()
    {
        // prepare
        /** @var \Psr\Http\Message\RequestInterface $requestStub */
        $requestStub = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        /** @var \Psr\Http\Message\ResponseInterface $responseStub */
        $responseStub = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $classUnderTest = new ArrayServerStack();
        $middlewareFake1 = new MiddlewareFake();
        $middlewareFake2 = new MiddlewareFake();
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $middlewareFake2 */
        /** @var \Psr\Http\Middleware\ServerMiddlewareInterface $middlewareFake1 */
        /** @var ArrayServerStack $classUnderTest */
        $classUnderTest = $classUnderTest->withMiddleware($middlewareFake2);
        $classUnderTest = $classUnderTest->withMiddleware($middlewareFake1);
        // test
        $classUnderTest->process($requestStub);
        // verified by annotation
    }
}
