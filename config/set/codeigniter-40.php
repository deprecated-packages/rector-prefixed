<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['CI_Controller' => '_PhpScoper567b66d83109\\CodeIgniter\\Controller', 'CI_Model' => '_PhpScoper567b66d83109\\CodeIgniter\\Model']]]);
};
