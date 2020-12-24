<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure()->bind(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class, \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class));
    $services->load('Rector\\RectorGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Rector']);
    $services->set(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector::class)->autowire(\false);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard::class);
};
