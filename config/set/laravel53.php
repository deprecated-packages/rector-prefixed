<?php

declare (strict_types=1);
namespace RectorPrefix20210120;

use Rector\Generic\Rector\Class_\RemoveTraitRector;
use RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        'Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};
