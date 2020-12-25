<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['CI_Controller' => '_PhpScoperfce0de0de1ce\\CodeIgniter\\Controller', 'CI_Model' => '_PhpScoperfce0de0de1ce\\CodeIgniter\\Model']]]);
};
