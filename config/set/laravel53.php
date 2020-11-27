<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Generic\Rector\Class_\RemoveTraitRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        '_PhpScoperbd5d0c5f7638\\Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};
