<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://laravel.com/docs/5.1/upgrade
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper8b9c402c5f32\\Illuminate\\Validation\\Validator' => '_PhpScoper8b9c402c5f32\\Illuminate\\Contracts\\Validation\\Validator']]]);
};
