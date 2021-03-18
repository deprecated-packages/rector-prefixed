<?php

declare (strict_types=1);
namespace RectorPrefix20210318;

use Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    // only for dev
    if (\interface_exists(\RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class)) {
        $services->set(\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
        $services->alias(\RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
        $services->set(\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
        $services->alias(\RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    }
};
