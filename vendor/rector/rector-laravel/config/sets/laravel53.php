<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Removing\Rector\Class_\RemoveTraitRector;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Removing\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        'RectorPrefix20210319\\Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};