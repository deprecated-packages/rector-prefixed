<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PhpParser\BuilderFactory;
use _PhpScoper0a2ac50786fa\PhpParser\NodeFinder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Parser;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScoper0a2ac50786fa\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper0a2ac50786fa\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
