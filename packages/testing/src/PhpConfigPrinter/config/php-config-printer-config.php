<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use _PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\_PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
