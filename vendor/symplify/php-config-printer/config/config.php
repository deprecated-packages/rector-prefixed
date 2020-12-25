<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper8b9c402c5f32\Symfony\Component\Yaml\Parser;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoper8b9c402c5f32\Symfony\Component\Yaml\Parser::class);
    $services->set(\PhpParser\BuilderFactory::class);
    $services->set(\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
