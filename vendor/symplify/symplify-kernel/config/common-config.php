<?php

declare (strict_types=1);
namespace RectorPrefix20210129;

use RectorPrefix20210129\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210129\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210129\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use RectorPrefix20210129\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use RectorPrefix20210129\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use RectorPrefix20210129\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20210129\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210129\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210129\Symplify\SmartFileSystem\FileSystemFilter;
use RectorPrefix20210129\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20210129\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20210129\Symplify\SmartFileSystem\Finder\SmartFinder;
use RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileSystem;
use RectorPrefix20210129\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
use function RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\RectorPrefix20210129\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20210129\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210129\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\RectorPrefix20210129\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\RectorPrefix20210129\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\RectorPrefix20210129\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\RectorPrefix20210129\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\RectorPrefix20210129\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210129\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\RectorPrefix20210129\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\RectorPrefix20210129\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class);
    // composer json factory
    $services->set(\RectorPrefix20210129\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    $services->set(\RectorPrefix20210129\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    $services->set(\RectorPrefix20210129\Symplify\ComposerJsonManipulator\Json\JsonCleaner::class);
    $services->set(\RectorPrefix20210129\Symplify\ComposerJsonManipulator\Json\JsonInliner::class);
};
