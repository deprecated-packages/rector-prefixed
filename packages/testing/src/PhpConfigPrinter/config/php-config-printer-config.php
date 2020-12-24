<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
