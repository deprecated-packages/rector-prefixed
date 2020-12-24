<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\PSR4\Composer\PSR4NamespaceMatcher;
use _PhpScoper0a6b37af0871\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\PSR4\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\_PhpScoper0a6b37af0871\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \_PhpScoper0a6b37af0871\Rector\PSR4\Composer\PSR4NamespaceMatcher::class);
};
