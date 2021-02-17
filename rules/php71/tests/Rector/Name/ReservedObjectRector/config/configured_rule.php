<?php

namespace RectorPrefix20210217;

use Rector\Php71\Rector\Name\ReservedObjectRector;
use RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php71\Rector\Name\ReservedObjectRector::class)->call('configure', [[\Rector\Php71\Rector\Name\ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => ['ReservedObject' => 'SmartObject', 'Object' => 'AnotherSmartObject']]]);
};
