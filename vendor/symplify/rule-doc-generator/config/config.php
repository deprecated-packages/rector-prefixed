<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\RuleDocGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Neon\NeonPrinter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
