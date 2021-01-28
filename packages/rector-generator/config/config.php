<?php

declare (strict_types=1);
namespace RectorPrefix20210128;

use Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use RectorPrefix20210128\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20210128\Symfony\Component\DependencyInjection\Loader\Configurator\service;
use RectorPrefix20210128\Symplify\SmartFileSystem\FileSystemGuard;
return static function (\RectorPrefix20210128\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure()->bind(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class, \RectorPrefix20210128\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class));
    $services->load('Rector\\RectorGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Rector']);
    $services->set(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class)->autowire(\false);
    $services->set(\RectorPrefix20210128\Symplify\SmartFileSystem\FileSystemGuard::class);
};
