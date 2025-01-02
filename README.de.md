# Jardis Factory
![Build Status](https://github.com/lane4jardis/factory/actions/workflows/ci.yml/badge.svg)

## Zweck
Die `Factory`-Klasse dient als flexible Instanziierungs- und Zugriffsfabrik für Klassen, die optionale Versionierung und Abhängigkeitsspritze (Dependency Injection) unterstützt.

## Beschreibung für Entwickler
Die Klasse bietet Methoden, um Instanzen von Klassen dynamisch zu erstellen oder diese aus einem bereitgestellten Container zu beziehen. Sie unterstützt:
- **Versionierung von Klassen** über eine `ClassVersionInterface`.
- **Dependency Injection** mittels eines `Psr\Container\ContainerInterface`.
- Dynamische Konstruktion von Klassen mit Unterstützung von Parametern.

### Hauptmethoden
- **`get($className, $version = null, ...$parameters)`**: Erstellt eine Instanz der angegebenen Klasse, optional mit Versionierung und Parametern.
- **`classVersion()`**: Gibt die aktuell konfigurierte Versionierungsinstanz zurück.
- **`setClassVersion($versionService)`**: Setzt eine neue Versionierungsinstanz.
- **`container()`**: Gibt den aktuellen Container zurück.
- **`setContainer($container)`**: Setzt den Container.

### Hinweise
- Falls ein Container bereitgestellt wird, wird die Instanz aus dem Container bezogen, sofern verfügbar.
- Bei fehlendem Container oder falls die Klasse nicht im Container registriert ist, wird die Instanz dynamisch mit Reflection erstellt.
- Das setzen eines Containers oder ClassVersion ist nur einmalig möglich.

### Verwendung
```php
$factory = new Factory($container, $classVersion);
$instance = $factory->get(MyClass::class, '1.0', ['param1', 'param2']);
```

Die Klasse bietet so eine zentrale Stelle für Instanziierung und Verwaltung von Objekten mit optionaler Versionierung und Dependency Injection.


## Beispielcode ohne Versionierung und ohne DI Container

```php
use Jardis\Factory\Factory;

$factory = new Factory();
$myClassInstance = $factory->get(MyClass::class)
$myClassInstance = $factory->get(MyClassWithToParameters::class, null, $var1, $var2)

```

## Beispielcode mit Versionierung von Klassen und ohne DI Container

```php
use Jardis\Factory\Factory;
use Jardis\Version\config\ClassVersionConfig;

$classVersions = ['subDirectory' => ['version1', 'version2']];
$classVersionConfig = new ClassVersionConfig($classVersions);
$classVersion = new ClassVersion($classVersionConfig);

$factory = new Factory(null, $classVersion);
$myClassInstance = $factory->get(MyClass::class)
$myClassInstance = $factory->get(MyClassWithToParameters::class, null, $var1, $var2)

```

## Beispielcode mit Versionierung von Klassen und DI Container

```php
use Jardis\Factory\Factory;
use Jardis\Version\config\ClassVersionConfig;

$container = new Container():
$classVersions = ['subDirectory' => ['version1', 'version2']];
$classVersionConfig = new ClassVersionConfig($classVersions);
$classVersion = new ClassVersion($classVersionConfig);

$factory = new Factory($container, $classVersion);
$myClassInstance = $factory->get(MyClass::class)
$myClassInstance = $factory->get(MyClassWithToParameters::class, null, $var1, $var2)

```

## Quickstart composer

```bash
composer require jardis/factory
make install
```

## Quickstart github

```bash
git clone https://github.com/Land4Jardis/factory.git
cd factory
```

---

## Lieferumfang im Github Repository

- **SourceFile**: 
  - src
  - tests
- **Support**: 
  - Docker Compose
  - .env
  - pre-commit-hook.sh
  - `Makefile` Einfach `make` in der Konsole aufrufen
- **Dokumentation**:
  - README.md

Der Aufbau des DockerFiles zum erstellen des PHP Images ist etwas umfänglicher gebaut als es für dieses Tool notwendig ist, da das resultierende PHP Image in verschiedenen Lane4 Tools eingesetzt wird.

[![Docker Image Version](https://img.shields.io/docker/v/lane4jardis/phpcli?sort=semver)](https://hub.docker.com/r/lane4jardis/phpcli)

Es wird auch darauf geachtet, das unsere Images so klein wie möglich sind und auf eurem System durch ggf. wiederholtes bauen der Images keine unnötigen Dateien verbleiben.

---

### Unsere Leitsätze:
#### Lieferung sehr hoher Softwarequalität
- Analysierbarkeit
- Anpassbarkeit
- Erweiterbarkeit
- Modularität
- Wartbarkeit
- Testbarkeit
- Skalierbarkeit
- Hohe Performance

Diese Komponente ist im Rahmen der Entwicklung des PHP Domain Driven Design Frameworks `Jardis` entstanden

Viel Freude bei der Nutzung!
