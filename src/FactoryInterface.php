<?php

declare(strict_types=1);

namespace Jardis\Factory;

use Exception;
use Jardis\Version\ClassVersionInterface;
use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $classVersion
     * @param mixed ...$parameters
     * @return T|null
     *@throws Exception
     */
    public function get(string $className, ?string $classVersion = null, ...$parameters);

    public function container(): ?ContainerInterface;

    public function setContainer(?ContainerInterface $container = null): self;

    public function classVersion(): ?ClassVersionInterface;

    public function setClassVersion(ClassVersionInterface $classVersion): self;
}
