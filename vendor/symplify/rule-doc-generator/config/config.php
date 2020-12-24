<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\RuleDocGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Neon\NeonPrinter::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
