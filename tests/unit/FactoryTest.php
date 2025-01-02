<?php

namespace Jardis\Factory\Tests;

use Jardis\Factory\Factory;
use Jardis\Version\ClassVersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;
use InvalidArgumentException;

class FactoryTest extends TestCase
{
    private $containerMock;
    private $classVersionMock;

    protected function setUp(): void
    {
        // Mocking ContainerInterface
        $this->containerMock = $this->createMock(ContainerInterface::class);

        // Mocking ClassVersionInterface
        $this->classVersionMock = $this->createMock(ClassVersionInterface::class);
    }

    public function testGetInstanceFromReflection(): void
    {
        $className = Factory::class;
        $mockInstance = new Factory($this->containerMock, $this->classVersionMock);

        $factory = new Factory();

        $result = $factory->get($className, null, $this->containerMock, $this->classVersionMock);

        $this->assertEquals($mockInstance, $result);
        $this->assertInstanceOf(ClassVersionInterface::class, $result->classVersion());
        $this->assertInstanceOf(ContainerInterface::class, $result->container());
    }

    public function testGetInstanceFromReflectionEmptyConstructor(): void
    {
        $className = stdClass::class;
        $mockInstance = new stdClass();

        $factory = new Factory();

        $result = $factory->get($className, null, $this->containerMock, $this->classVersionMock);

        $this->assertEquals($mockInstance, $result);
    }

    public function testGetInstanceFromContainer(): void
    {
        $className = stdClass::class;

        $mockInstance = new stdClass();

        // Konfiguration des Container-Mocks
        $this->containerMock->method('has')->with($className)->willReturn(true);
        $this->containerMock->method('get')->with($className)->willReturn($mockInstance);

        $factory = new Factory($this->containerMock);

        $result = $factory->get($className);

        $this->assertSame($mockInstance, $result);
    }

    public function testGetHandlesClassVersionAsString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $className = stdClass::class;
        $versionHandler = 'VersionedHandler';

        $mockInstance = new stdClass();

        // Konfiguration des ClassVersionInterface-Mocks
        $this->classVersionMock->method('__invoke')->with($className, null)->willReturn($versionHandler);

        // Konfiguration des Container-Mocks
        $this->containerMock->method('has')->with($versionHandler)->willReturn(true);
        $this->containerMock->method('get')->with($versionHandler)->willReturn($mockInstance);

        $factory = new Factory($this->containerMock, $this->classVersionMock);

        $result = $factory->get($className);

        $this->assertSame($mockInstance, $result);
    }

    public function testGetHandlesClassVersionAsObject(): void
    {
        $className = stdClass::class;
        $mockInstance = new stdClass();

        // Konfiguration des ClassVersionInterface-Mocks
        $this->classVersionMock->method('__invoke')->with($className, null)->willReturn($mockInstance);

        $factory = new Factory(null, $this->classVersionMock);

        $result = $factory->get($className);

        $this->assertSame($mockInstance, $result);
    }

    public function testGetCreatesInstanceWhenContainerDoesNotHaveClass(): void
    {
        $className = stdClass::class;

        // Konfiguration des Container-Mocks
        $this->containerMock->method('has')->with($className)->willReturn(false);

        $factory = new Factory($this->containerMock);

        $result = $factory->get($className);

        $this->assertInstanceOf($className, $result);
    }

    public function testClassVersionAndContainerAreSetCorrectly(): void
    {
        $factory = new Factory();

        $this->assertNull($factory->classVersion());
        $this->assertNull($factory->container());

        $factory->setClassVersion($this->classVersionMock);
        $this->assertSame($this->classVersionMock, $factory->classVersion());

        $factory->setContainer($this->containerMock);
        $this->assertSame($this->containerMock, $factory->container());
    }

    public function testSetContainerSetsNull(): void
    {
        $factory = new Factory($this->containerMock);

        $factory->setContainer(null);

        $this->assertNull($factory->container());
    }
}
