<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class);
    // composer json factory
    $services->set(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Json\JsonCleaner::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Json\JsonInliner::class);
};
