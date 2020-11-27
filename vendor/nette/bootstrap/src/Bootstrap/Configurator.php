<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette;

use _PhpScopera143bcca66cb\Composer\Autoload\ClassLoader;
use _PhpScopera143bcca66cb\Nette;
use _PhpScopera143bcca66cb\Nette\DI;
use _PhpScopera143bcca66cb\Tracy;
/**
 * Initial system DI container generator.
 */
class Configurator
{
    use SmartObject;
    public const COOKIE_SECRET = 'nette-debug';
    /** @var callable[]  function (Configurator $sender, DI\Compiler $compiler); Occurs after the compiler is created */
    public $onCompile;
    /** @var array */
    public $defaultExtensions = ['application' => [\_PhpScopera143bcca66cb\Nette\Bridges\ApplicationDI\ApplicationExtension::class, ['%debugMode%', ['%appDir%'], '%tempDir%/cache/nette.application']], 'cache' => [\_PhpScopera143bcca66cb\Nette\Bridges\CacheDI\CacheExtension::class, ['%tempDir%']], 'constants' => \_PhpScopera143bcca66cb\Nette\DI\Extensions\ConstantsExtension::class, 'database' => [\_PhpScopera143bcca66cb\Nette\Bridges\DatabaseDI\DatabaseExtension::class, ['%debugMode%']], 'decorator' => \_PhpScopera143bcca66cb\Nette\DI\Extensions\DecoratorExtension::class, 'di' => [\_PhpScopera143bcca66cb\Nette\DI\Extensions\DIExtension::class, ['%debugMode%']], 'extensions' => \_PhpScopera143bcca66cb\Nette\DI\Extensions\ExtensionsExtension::class, 'forms' => \_PhpScopera143bcca66cb\Nette\Bridges\FormsDI\FormsExtension::class, 'http' => [\_PhpScopera143bcca66cb\Nette\Bridges\HttpDI\HttpExtension::class, ['%consoleMode%']], 'inject' => \_PhpScopera143bcca66cb\Nette\DI\Extensions\InjectExtension::class, 'latte' => [\_PhpScopera143bcca66cb\Nette\Bridges\ApplicationDI\LatteExtension::class, ['%tempDir%/cache/latte', '%debugMode%']], 'mail' => \_PhpScopera143bcca66cb\Nette\Bridges\MailDI\MailExtension::class, 'php' => \_PhpScopera143bcca66cb\Nette\DI\Extensions\PhpExtension::class, 'routing' => [\_PhpScopera143bcca66cb\Nette\Bridges\ApplicationDI\RoutingExtension::class, ['%debugMode%']], 'search' => [\_PhpScopera143bcca66cb\Nette\DI\Extensions\SearchExtension::class, ['%tempDir%/cache/nette.search']], 'security' => [\_PhpScopera143bcca66cb\Nette\Bridges\SecurityDI\SecurityExtension::class, ['%debugMode%']], 'session' => [\_PhpScopera143bcca66cb\Nette\Bridges\HttpDI\SessionExtension::class, ['%debugMode%', '%consoleMode%']], 'tracy' => [\_PhpScopera143bcca66cb\Tracy\Bridges\Nette\TracyExtension::class, ['%debugMode%', '%consoleMode%']]];
    /** @var string[] of classes which shouldn't be autowired */
    public $autowireExcludedClasses = [\ArrayAccess::class, \Countable::class, \IteratorAggregate::class, \stdClass::class, \Traversable::class];
    /** @var array */
    protected $parameters;
    /** @var array */
    protected $dynamicParameters = [];
    /** @var array */
    protected $services = [];
    /** @var array of string|array */
    protected $configs = [];
    public function __construct()
    {
        $this->parameters = self::escape($this->getDefaultParameters());
    }
    /**
     * Set parameter %debugMode%.
     * @param  bool|string|array  $value
     * @return static
     */
    public function setDebugMode($value)
    {
        if (\is_string($value) || \is_array($value)) {
            $value = static::detectDebugMode($value);
        } elseif (!\is_bool($value)) {
            throw new \_PhpScopera143bcca66cb\Nette\InvalidArgumentException(\sprintf('Value must be either a string, array, or boolean, %s given.', \gettype($value)));
        }
        $this->parameters['debugMode'] = $value;
        $this->parameters['productionMode'] = !$this->parameters['debugMode'];
        // compatibility
        return $this;
    }
    public function isDebugMode() : bool
    {
        return $this->parameters['debugMode'];
    }
    /**
     * Sets path to temporary directory.
     * @return static
     */
    public function setTempDirectory(string $path)
    {
        $this->parameters['tempDir'] = self::escape($path);
        return $this;
    }
    /**
     * Sets the default timezone.
     * @return static
     */
    public function setTimeZone(string $timezone)
    {
        \date_default_timezone_set($timezone);
        @\ini_set('date.timezone', $timezone);
        // @ - function may be disabled
        return $this;
    }
    /**
     * Adds new parameters. The %params% will be expanded.
     * @return static
     */
    public function addParameters(array $params)
    {
        $this->parameters = \_PhpScopera143bcca66cb\Nette\DI\Config\Helpers::merge($params, $this->parameters);
        return $this;
    }
    /**
     * Adds new dynamic parameters.
     * @return static
     */
    public function addDynamicParameters(array $params)
    {
        $this->dynamicParameters = $params + $this->dynamicParameters;
        return $this;
    }
    /**
     * Add instances of services.
     * @return static
     */
    public function addServices(array $services)
    {
        $this->services = $services + $this->services;
        return $this;
    }
    protected function getDefaultParameters() : array
    {
        $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        $last = \end($trace);
        $debugMode = static::detectDebugMode();
        $loaderRc = \class_exists(\_PhpScopera143bcca66cb\Composer\Autoload\ClassLoader::class) ? new \ReflectionClass(\_PhpScopera143bcca66cb\Composer\Autoload\ClassLoader::class) : null;
        return ['appDir' => isset($trace[1]['file']) ? \dirname($trace[1]['file']) : null, 'wwwDir' => isset($last['file']) ? \dirname($last['file']) : null, 'vendorDir' => $loaderRc ? \dirname($loaderRc->getFileName(), 2) : null, 'debugMode' => $debugMode, 'productionMode' => !$debugMode, 'consoleMode' => \PHP_SAPI === 'cli'];
    }
    public function enableTracy(string $logDirectory = null, string $email = null) : void
    {
        \_PhpScopera143bcca66cb\Tracy\Debugger::$strictMode = \true;
        \_PhpScopera143bcca66cb\Tracy\Debugger::enable(!$this->parameters['debugMode'], $logDirectory, $email);
        \_PhpScopera143bcca66cb\Tracy\Bridges\Nette\Bridge::initialize();
    }
    /**
     * Alias for enableTracy()
     */
    public function enableDebugger(string $logDirectory = null, string $email = null) : void
    {
        $this->enableTracy($logDirectory, $email);
    }
    /**
     * @throws Nette\NotSupportedException if RobotLoader is not available
     */
    public function createRobotLoader() : \_PhpScopera143bcca66cb\Nette\Loaders\RobotLoader
    {
        if (!\class_exists(\_PhpScopera143bcca66cb\Nette\Loaders\RobotLoader::class)) {
            throw new \_PhpScopera143bcca66cb\Nette\NotSupportedException('RobotLoader not found, do you have `nette/robot-loader` package installed?');
        }
        $loader = new \_PhpScopera143bcca66cb\Nette\Loaders\RobotLoader();
        $loader->setTempDirectory($this->getCacheDirectory() . '/nette.robotLoader');
        $loader->setAutoRefresh($this->parameters['debugMode']);
        if (isset($this->defaultExtensions['application'])) {
            $this->defaultExtensions['application'][1][1] = null;
            $this->defaultExtensions['application'][1][3] = $loader;
        }
        return $loader;
    }
    /**
     * Adds configuration file.
     * @param  string|array  $config
     * @return static
     */
    public function addConfig($config)
    {
        $this->configs[] = $config;
        return $this;
    }
    /**
     * Returns system DI container.
     */
    public function createContainer() : \_PhpScopera143bcca66cb\Nette\DI\Container
    {
        $class = $this->loadContainer();
        $container = new $class($this->dynamicParameters);
        foreach ($this->services as $name => $service) {
            $container->addService($name, $service);
        }
        $container->initialize();
        return $container;
    }
    /**
     * Loads system DI container class and returns its name.
     */
    public function loadContainer() : string
    {
        $loader = new \_PhpScopera143bcca66cb\Nette\DI\ContainerLoader($this->getCacheDirectory() . '/nette.configurator', $this->parameters['debugMode']);
        $class = $loader->load([$this, 'generateContainer'], [
            $this->parameters,
            \array_keys($this->dynamicParameters),
            $this->configs,
            \PHP_VERSION_ID - \PHP_RELEASE_VERSION,
            // minor PHP version
            \class_exists(\_PhpScopera143bcca66cb\Composer\Autoload\ClassLoader::class) ? \filemtime((new \ReflectionClass(\_PhpScopera143bcca66cb\Composer\Autoload\ClassLoader::class))->getFilename()) : null,
        ]);
        return $class;
    }
    /**
     * @internal
     */
    public function generateContainer(\_PhpScopera143bcca66cb\Nette\DI\Compiler $compiler) : void
    {
        $loader = $this->createLoader();
        $loader->setParameters($this->parameters);
        foreach ($this->configs as $config) {
            if (\is_string($config)) {
                $compiler->loadConfig($config, $loader);
            } else {
                $compiler->addConfig($config);
            }
        }
        $compiler->addConfig(['parameters' => $this->parameters]);
        $compiler->setDynamicParameterNames(\array_keys($this->dynamicParameters));
        $builder = $compiler->getContainerBuilder();
        $builder->addExcludedClasses($this->autowireExcludedClasses);
        foreach ($this->defaultExtensions as $name => $extension) {
            [$class, $args] = \is_string($extension) ? [$extension, []] : $extension;
            if (\class_exists($class)) {
                $args = \_PhpScopera143bcca66cb\Nette\DI\Helpers::expand($args, $this->parameters, \true);
                $compiler->addExtension($name, (new \ReflectionClass($class))->newInstanceArgs($args));
            }
        }
        $this->onCompile($this, $compiler);
    }
    protected function createLoader() : \_PhpScopera143bcca66cb\Nette\DI\Config\Loader
    {
        return new \_PhpScopera143bcca66cb\Nette\DI\Config\Loader();
    }
    protected function getCacheDirectory() : string
    {
        if (empty($this->parameters['tempDir'])) {
            throw new \_PhpScopera143bcca66cb\Nette\InvalidStateException('Set path to temporary directory using setTempDirectory().');
        }
        $dir = \_PhpScopera143bcca66cb\Nette\DI\Helpers::expand('%tempDir%/cache', $this->parameters, \true);
        \_PhpScopera143bcca66cb\Nette\Utils\FileSystem::createDir($dir);
        return $dir;
    }
    /********************* tools ****************d*g**/
    /**
     * Detects debug mode by IP addresses or computer names whitelist detection.
     * @param  string|array  $list
     */
    public static function detectDebugMode($list = null) : bool
    {
        $addr = $_SERVER['REMOTE_ADDR'] ?? \php_uname('n');
        $secret = \is_string($_COOKIE[self::COOKIE_SECRET] ?? null) ? $_COOKIE[self::COOKIE_SECRET] : null;
        $list = \is_string($list) ? \preg_split('#[,\\s]+#', $list) : (array) $list;
        if (!isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !isset($_SERVER['HTTP_FORWARDED'])) {
            $list[] = '127.0.0.1';
            $list[] = '::1';
            $list[] = '[::1]';
            // workaround for PHP < 7.3.4
        }
        return \in_array($addr, $list, \true) || \in_array("{$secret}@{$addr}", $list, \true);
    }
    /**
     * Expand counterpart.
     */
    private static function escape($value)
    {
        if (\is_array($value)) {
            return \array_map([self::class, 'escape'], $value);
        } elseif (\is_string($value)) {
            return \str_replace('%', '%%', $value);
        }
        return $value;
    }
}
