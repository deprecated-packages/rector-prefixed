<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Console\ConsoleApplicationFactory::class);
    // composer json factory
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ComposerJsonFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Json\JsonCleaner::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Json\JsonInliner::class);
};
