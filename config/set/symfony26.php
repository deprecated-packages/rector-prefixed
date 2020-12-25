<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Symfony2\Rector\MethodCall\AddFlashRector;
use Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector::class);
    $services->set(\Rector\Symfony2\Rector\MethodCall\AddFlashRector::class);
};
