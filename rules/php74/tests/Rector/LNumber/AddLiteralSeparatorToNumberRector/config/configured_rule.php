<?php

namespace RectorPrefix20210209;

use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use RectorPrefix20210209\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210209\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class)->call('configure', [[\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::LIMIT_VALUE => 1000000]]);
};