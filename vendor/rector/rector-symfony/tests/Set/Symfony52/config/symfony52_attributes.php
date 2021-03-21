<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

use Rector\Symfony\Set\SymfonySetList;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../config/config.php');
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_52);
};
