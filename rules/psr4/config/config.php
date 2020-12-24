<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PSR4\Composer\PSR4NamespaceMatcher;
use _PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\PSR4\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\_PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \_PhpScopere8e811afab72\Rector\PSR4\Composer\PSR4NamespaceMatcher::class);
};
