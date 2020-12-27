<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use RectorPrefix20201227\Symplify\SmartFileSystem\FileSystemGuard;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure()->bind(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class, \RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class));
    $services->load('RectorPrefix20201227\Rector\\RectorGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Rector']);
    $services->set(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class)->autowire(\false);
    $services->set(\RectorPrefix20201227\Symplify\SmartFileSystem\FileSystemGuard::class);
};
