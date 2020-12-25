<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector::class);
};
