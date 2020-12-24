<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Symfony2\Rector\MethodCall\AddFlashRector;
use _PhpScoperb75b35f52b74\Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony2\Rector\MethodCall\RedirectToRouteRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony2\Rector\MethodCall\AddFlashRector::class);
};
