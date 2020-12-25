<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Generic\Rector\Class_\RemoveTraitRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        '_PhpScoperbf340cb0be9d\\Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};
