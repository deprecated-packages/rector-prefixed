<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector::class);
};
