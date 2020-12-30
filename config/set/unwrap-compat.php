<?php

declare (strict_types=1);
namespace RectorPrefix20201230;

use Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector;
use RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Polyfill\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector::class);
};
