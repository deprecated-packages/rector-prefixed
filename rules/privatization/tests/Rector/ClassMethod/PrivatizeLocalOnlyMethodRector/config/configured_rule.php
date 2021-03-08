<?php

namespace RectorPrefix20210308;

use Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
};
