<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use Symplify\SmartFileSystem\FileSystemGuard;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure()->bind(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class, \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class));
    $services->load('Rector\\RectorGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Rector']);
    $services->set(\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class)->autowire(\false);
    $services->set(\Symplify\SmartFileSystem\FileSystemGuard::class);
};
