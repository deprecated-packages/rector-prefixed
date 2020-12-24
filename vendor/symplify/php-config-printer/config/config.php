<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PhpParser\BuilderFactory;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Yaml\Parser;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
