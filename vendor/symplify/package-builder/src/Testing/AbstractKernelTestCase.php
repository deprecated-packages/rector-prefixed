<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use ReflectionClass;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScoperb75b35f52b74\Symfony\Contracts\Service\ResetInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Exception\HttpKernel\MissingInterfaceException;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * Inspiration
 * @see https://github.com/symfony/symfony/blob/master/src/Symfony/Bundle/FrameworkBundle/Test/KernelTestCase.php
 */
abstract class AbstractKernelTestCase extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;
    /**
     * @var ContainerInterface|Container
     */
    protected static $container;
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    protected function bootKernelWithConfigs(string $kernelClass, array $configs) : \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface
    {
        // unwrap file infos to real paths
        $configFilePaths = $this->resolveConfigFilePaths($configs);
        $configsHash = $this->resolveConfigsHash($configFilePaths);
        $this->ensureKernelShutdown();
        $kernel = new $kernelClass('test_' . $configsHash, \true);
        if (!$kernel instanceof \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface) {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $this->ensureIsConfigAwareKernel($kernel);
        /** @var ExtraConfigAwareKernelInterface $kernel */
        $kernel->setConfigs($configFilePaths);
        static::$kernel = $this->bootAndReturnKernel($kernel);
        return static::$kernel;
    }
    /**
     * Syntax sugger to remove static from the test cases vission
     */
    protected function getService(string $type) : object
    {
        if (self::$container === null) {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException('First, crewate container with booKernel(KernelClass::class)');
        }
        return self::$container->get($type);
    }
    protected function bootKernel(string $kernelClass) : void
    {
        $this->ensureKernelShutdown();
        $kernel = new $kernelClass('test', \true);
        if (!$kernel instanceof \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface) {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        static::$kernel = $this->bootAndReturnKernel($kernel);
    }
    /**
     * Shuts the kernel down if it was used in the test.
     */
    protected function ensureKernelShutdown() : void
    {
        if (static::$kernel !== null) {
            // make sure boot() is called
            // @see https://github.com/symfony/symfony/pull/31202/files
            $kernelReflectionClass = new \ReflectionClass(static::$kernel);
            $containerPropertyReflection = $kernelReflectionClass->getProperty('container');
            $containerPropertyReflection->setAccessible(\true);
            $kernel = $containerPropertyReflection->getValue(static::$kernel);
            if ($kernel !== null) {
                $container = static::$kernel->getContainer();
                static::$kernel->shutdown();
                if ($container instanceof \_PhpScoperb75b35f52b74\Symfony\Contracts\Service\ResetInterface) {
                    $container->reset();
                }
            }
        }
        static::$container = null;
    }
    /**
     * @param string[] $configs
     */
    private function resolveConfigsHash(array $configs) : string
    {
        $configsHash = '';
        foreach ($configs as $config) {
            $configsHash .= \md5_file($config);
        }
        return \md5($configsHash);
    }
    private function ensureIsConfigAwareKernel(\_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface $kernel) : void
    {
        if ($kernel instanceof \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Exception\HttpKernel\MissingInterfaceException(\sprintf('"%s" is missing an "%s" interface', \get_class($kernel), \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class));
    }
    private function bootAndReturnKernel(\_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface $kernel) : \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface
    {
        $kernel->boot();
        $container = $kernel->getContainer();
        // private → public service hack?
        if ($container->has('test.service_container')) {
            $container = $container->get('test.service_container');
        }
        if (!$container instanceof \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface) {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        // has output? keep it silent out of tests
        if ($container->has(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle::class)) {
            $symfonyStyle = $container->get(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle::class);
            $symfonyStyle->setVerbosity(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        static::$container = $container;
        return $kernel;
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return string[]
     */
    private function resolveConfigFilePaths(array $configs) : array
    {
        $configFilePaths = [];
        foreach ($configs as $config) {
            $configFilePaths[] = $config instanceof \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo ? $config->getRealPath() : $config;
        }
        return $configFilePaths;
    }
}
