<?php

declare (strict_types=1);
namespace RectorPrefix20210404;

use Rector\PHPUnit\Rector\MethodCall\WithConsecutiveArgToArrayRector;
use RectorPrefix20210404\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210404\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\MethodCall\WithConsecutiveArgToArrayRector::class);
};
