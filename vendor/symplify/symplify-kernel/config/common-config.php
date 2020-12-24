<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
use function _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class);
    // composer json factory
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Json\JsonCleaner::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Json\JsonInliner::class);
};
