<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Caching\Config;

use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Inspired by https://github.com/symplify/easy-coding-standard/blob/e598ab54686e416788f28fcfe007fd08e0f371d9/packages/changed-files-detector/src/FileHashComputer.php
 * @see \Rector\Caching\Tests\Config\FileHashComputerTest
 */
final class FileHashComputer
{
    public function compute(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        $this->ensureIsYamlOrPhp($fileInfo);
        $containerBuilder = new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder();
        $fileLoader = $this->createFileLoader($fileInfo, $containerBuilder);
        $fileLoader->load($fileInfo->getRealPath());
        $parameterBag = $containerBuilder->getParameterBag();
        return $this->arrayToHash($containerBuilder->getDefinitions()) . $this->arrayToHash($parameterBag->all());
    }
    private function ensureIsYamlOrPhp(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        if ($fileInfo->hasSuffixes(['yml', 'yaml', 'php'])) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException(\sprintf(
            // getRealPath() cannot be used, as it breaks in phar
            'Provide only YAML/PHP file, ready for Symfony Dependency Injection. "%s" given',
            $fileInfo->getRelativeFilePath()
        ));
    }
    private function createFileLoader(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \_PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator([$fileInfo->getPath()]);
        $fileLoaders = [new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, $fileLocator), new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, $fileLocator), new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderResolver($fileLoaders);
        $loader = $loaderResolver->resolve($fileInfo->getRealPath());
        if (!$loader) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
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
