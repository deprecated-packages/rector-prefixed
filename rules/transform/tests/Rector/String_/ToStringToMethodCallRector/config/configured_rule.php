<?php

namespace RectorPrefix20210305;

use Rector\Transform\Rector\String_\ToStringToMethodCallRector;
use RectorPrefix20210305\Symfony\Component\Config\ConfigCache;
use RectorPrefix20210305\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210305\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\String_\ToStringToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\RectorPrefix20210305\Symfony\Component\Config\ConfigCache::class => 'getPath']]]);
};
