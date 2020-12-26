<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://laravel.com/docs/5.1/upgrade
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\Illuminate\\Validation\\Validator' => 'RectorPrefix2020DecSat\\Illuminate\\Contracts\\Validation\\Validator']]]);
};
