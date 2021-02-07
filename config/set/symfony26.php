<?php

declare (strict_types=1);
namespace RectorPrefix20210207;

use Rector\Symfony2\Rector\MethodCall\AddFlashRector;
use Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector;
use RectorPrefix20210207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector::class);
    $services->set(\Rector\Symfony2\Rector\MethodCall\AddFlashRector::class);
};
