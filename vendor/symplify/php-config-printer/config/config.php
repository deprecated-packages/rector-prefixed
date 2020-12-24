<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PhpParser\BuilderFactory;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symfony\Component\Yaml\Parser;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScopere8e811afab72\PhpParser\NodeFinder::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
