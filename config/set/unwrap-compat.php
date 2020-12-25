<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector::class);
};
