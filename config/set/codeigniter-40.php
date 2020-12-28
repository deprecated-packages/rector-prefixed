<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['CI_Controller' => 'RectorPrefix20201228\\CodeIgniter\\Controller', 'CI_Model' => 'RectorPrefix20201228\\CodeIgniter\\Model']]]);
};
