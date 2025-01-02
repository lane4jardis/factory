<?php

declare(strict_types=1);

namespace Jardis\Factory;

use Exception;
use Jardis\Version\ClassVersionInterface;
use Psr\Container\ContainerInterface;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Returns the instances of classes based reflection and classVersion or DI container
 */
class Factory implements FactoryInterface
{
    private ?ClassVersionInterface $classVersion;
    private ?ContainerInterface $container;

    public function __construct(?ContainerInterface $container = null, ?ClassVersionInterface $classVersion = null)
    {
        $this->container = $container;
        $this->classVersion = $classVersion;
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $classVersion
     * @param mixed ...$parameters
     * @return T|object|null
     * @throws Exception
     */
    public function get(string $className, ?string $classVersion = null, ...$parameters)
    {
        $handler = $this->classVersion ? ($this->classVersion)($className, $classVersion) : $className;

        if (!is_string($handler)) {
            return $handler;
        }

        if (!class_exists($handler)) {
            return throw new InvalidArgumentException(sprintf('Class %s not found!', $handler));
        }

        return ($this->container && $this->container->has($handler))
            ? $this->container->get($handler)
            : $this->createInstance($handler, $parameters);
    }

    public function classVersion(): ?ClassVersionInterface
    {
        return $this->classVersion;
    }

    public function setClassVersion(ClassVersionInterface $classVersion): self
    {
        $this->classVersion = $this->classVersion ?? $classVersion;

        return $this;
    }

    public function container(): ?ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(?ContainerInterface $container = null): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @param array<int|string, mixed> $parameters
     * @return T|object|null
     * @throws Exception
     */
    private function createInstance(string $className, array $parameters)
    {
        if (empty($parameters[0])) {
            return new $className();
        }

        $class = new ReflectionClass($className);
        $parameters = is_array($parameters[0]) ? $parameters[0] : $parameters;

        return empty($class->getConstructor())
            ? new $className()
            : $class->newInstanceArgs($parameters);
    }
}
