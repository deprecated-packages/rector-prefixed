<?php

declare (strict_types=1);
namespace RectorPrefix20210201;

use RectorPrefix20210201\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210201\Symplify\PackageBuilder\Neon\NeonPrinter;
use RectorPrefix20210201\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
return static function (\RectorPrefix20210201\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210201\Symplify\\RuleDocGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\RectorPrefix20210201\Symplify\PackageBuilder\Neon\NeonPrinter::class);
    $services->set(\RectorPrefix20210201\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
