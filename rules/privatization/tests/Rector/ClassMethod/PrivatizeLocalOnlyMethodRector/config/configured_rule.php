<?php

namespace RectorPrefix20210303;

use Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
};
