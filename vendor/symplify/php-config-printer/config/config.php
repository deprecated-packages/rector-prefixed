<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\PhpParser\BuilderFactory;
use _PhpScoper0a6b37af0871\PhpParser\NodeFinder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symfony\Component\Yaml\Parser;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
