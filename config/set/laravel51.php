<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://laravel.com/docs/5.1/upgrade
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper5edc98a7cce2\\Illuminate\\Validation\\Validator' => '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Validation\\Validator']]]);
};
