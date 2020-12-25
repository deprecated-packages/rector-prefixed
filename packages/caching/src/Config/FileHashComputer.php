<?php

declare (strict_types=1);
namespace Rector\Caching\Config;

use Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper567b66d83109\Symfony\Component\Config\FileLocator;
use _PhpScoper567b66d83109\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper567b66d83109\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Inspired by https://github.com/symplify/easy-coding-standard/blob/e598ab54686e416788f28fcfe007fd08e0f371d9/packages/changed-files-detector/src/FileHashComputer.php
 * @see \Rector\Caching\Tests\Config\FileHashComputerTest
 */
final class FileHashComputer
{
    public function compute(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        $this->ensureIsYamlOrPhp($fileInfo);
        $containerBuilder = new \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerBuilder();
        $fileLoader = $this->createFileLoader($fileInfo, $containerBuilder);
        $fileLoader->load($fileInfo->getRealPath());
        $parameterBag = $containerBuilder->getParameterBag();
        return $this->arrayToHash($containerBuilder->getDefinitions()) . $this->arrayToHash($parameterBag->all());
    }
    private function ensureIsYamlOrPhp(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        if ($fileInfo->hasSuffixes(['yml', 'yaml', 'php'])) {
            return;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf(
            // getRealPath() cannot be used, as it breaks in phar
            'Provide only YAML/PHP file, ready for Symfony Dependency Injection. "%s" given',
            $fileInfo->getRelativeFilePath()
        ));
    }
    private function createFileLoader(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \_PhpScoper567b66d83109\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \_PhpScoper567b66d83109\Symfony\Component\Config\FileLocator([$fileInfo->getPath()]);
        $fileLoaders = [new \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, $fileLocator), new \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, $fileLocator), new \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \_PhpScoper567b66d83109\Symfony\Component\Config\Loader\LoaderResolver($fileLoaders);
        $loader = $loaderResolver->resolve($fileInfo->getRealPath());
        if (!$loader) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $loader;
    }
    /**
     * @param mixed[] $array
     */
    private function arrayToHash(array $array) : string
    {
        return \md5(\serialize($array));
    }
}
