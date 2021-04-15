<?php

declare (strict_types=1);
namespace RectorPrefix20210415;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210415\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://laravel.com/docs/5.1/upgrade
return static function (\RectorPrefix20210415\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Illuminate\\Validation\\Validator' => 'Illuminate\\Contracts\\Validation\\Validator']]]);
};
