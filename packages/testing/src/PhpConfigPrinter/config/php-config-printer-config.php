<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use _PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
