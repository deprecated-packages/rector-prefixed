<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class);
    // composer json factory
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonCleaner::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonInliner::class);
};
