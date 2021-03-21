<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://laravel.com/docs/5.1/upgrade
return static function (\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20210321\\Illuminate\\Validation\\Validator' => 'RectorPrefix20210321\\Illuminate\\Contracts\\Validation\\Validator']]]);
};
