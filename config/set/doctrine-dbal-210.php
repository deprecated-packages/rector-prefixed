<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-type-constants
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20201228\\Doctrine\\DBAL\\Types\\Type' => 'RectorPrefix20201228\\Doctrine\\DBAL\\Types\\Types']]]);
};
