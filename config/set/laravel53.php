<?php

declare (strict_types=1);
namespace RectorPrefix20201226;

use Rector\Generic\Rector\Class_\RemoveTraitRector;
use RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        'RectorPrefix20201226\\Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};
