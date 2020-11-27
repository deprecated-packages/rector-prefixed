<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
