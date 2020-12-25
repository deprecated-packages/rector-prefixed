<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
