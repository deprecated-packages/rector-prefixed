<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use _PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
