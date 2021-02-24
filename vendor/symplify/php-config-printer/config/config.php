<?php

declare (strict_types=1);
namespace RectorPrefix20210224;

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use RectorPrefix20210224\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210224\Symfony\Component\Yaml\Parser;
use RectorPrefix20210224\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210224\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
return static function (\RectorPrefix20210224\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210224\Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\PhpParser\NodeFinder::class);
    $services->set(\RectorPrefix20210224\Symfony\Component\Yaml\Parser::class);
    $services->set(\PhpParser\BuilderFactory::class);
    $services->set(\RectorPrefix20210224\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    $services->set(\RectorPrefix20210224\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
