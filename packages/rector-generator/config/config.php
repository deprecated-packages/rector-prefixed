<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure()->bind(\_PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class, \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class));
    $services->load('Rector\\RectorGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Rector']);
    $services->set(\_PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class)->autowire(\false);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard::class);
};
