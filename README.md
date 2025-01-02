
# Jardis Factory
![Build Status](https://github.com/lane4jardis/factory/actions/workflows/ci.yml/badge.svg)

## Purpose
The `Factory` class serves as a flexible instantiation and access factory for classes, supporting optional versioning and dependency injection (DI).

## Description for Developers
The class provides methods to dynamically create instances of classes or retrieve them from a provided container. It supports:
- **Class versioning** through a `ClassVersionInterface`.
- **Dependency Injection** via a `Psr\Container\ContainerInterface`.
- Dynamic construction of classes with parameter support.

### Key Methods
- **`get($className, $version = null, ...$parameters)`**: Creates an instance of the specified class, optionally with versioning and parameters.
- **`classVersion()`**: Returns the currently configured versioning instance.
- **`setClassVersion($versionService)`**: Sets a new versioning instance.
- **`container()`**: Returns the current container.
- **`setContainer($container)`**: Sets the container.

### Notes
- If a container is provided, the instance is retrieved from the container if available.
- If no container is available or the class is not registered in the container, the instance is dynamically created using reflection.
- Setting a container or ClassVersion is only possible once.

### Usage
```php
$factory = new Factory($container, $classVersion);
$instance = $factory->get(MyClass::class, '1.0', ['param1', 'param2']);
```

The class provides a central point for instantiation and management of objects with optional versioning and dependency injection.

## Example code without classVersioning and without DI container

```php
use Jardis\Factory\Factory;

$factory = new Factory();
$myClassInstance = $factory->get(MyClass::class);
$myClassInstance = $factory->get(MyClassWithTwoParameters::class, null, $var1, $var2);
```

## Example code with classVersioning and without DI container

```php
use Jardis\Factory\Factory;
use Jardis\Version\config\ClassVersionConfig;

$classVersions = ['subDirectory' => ['version1', 'version2']];
$classVersionConfig = new ClassVersionConfig($classVersions);
$classVersion = new ClassVersion($classVersionConfig);

$factory = new Factory(null, $classVersion);
$myClassInstance = $factory->get(MyClass::class);
$myClassInstance = $factory->get(MyClassWithTwoParameters::class, null, $var1, $var2);
```

## Example code with classVersioning and DI container

```php
use Jardis\Factory\Factory;
use Jardis\Version\config\ClassVersionConfig;

$container = new Container();
$classVersions = ['subDirectory' => ['version1', 'version2']];
$classVersionConfig = new ClassVersionConfig($classVersions);
$classVersion = new ClassVersion($classVersionConfig);

$factory = new Factory($container, $classVersion);
$myClassInstance = $factory->get(MyClass::class);
$myClassInstance = $factory->get(MyClassWithTwoParameters::class, null, $var1, $var2);
```

## Quickstart Composer

```bash
composer require jardis/factory
make install
```

## Quickstart GitHub

```bash
git clone https://github.com/Land4Jardis/factory.git
cd factory
```

---

## Contents in the GitHub Repository

- **Source Files**:
    - src
    - tests
- **Support**:
    - Docker Compose
    - .env
    - pre-commit-hook.sh
    - `Makefile` Simply run `make` in the console
- **Documentation**:
    - README.md

The DockerFile for creating the PHP image is built more extensively than necessary for this tool since the resulting PHP image is used in various Lane4 tools.

[![Docker Image Version](https://img.shields.io/docker/v/lane4jardis/phpcli?sort=semver)](https://hub.docker.com/r/lane4jardis/phpcli)

We also ensure that our images are as small as possible and leave no unnecessary files on your system during repeated image builds.

---

### Our Principles:
#### Delivering very high software quality
- Analyzability
- Adaptability
- Extensibility
- Modularity
- Maintainability
- Testability
- Scalability
- High Performance

This component was developed as part of the PHP Domain Driven Design Framework `Jardis`.

Enjoy using it!
