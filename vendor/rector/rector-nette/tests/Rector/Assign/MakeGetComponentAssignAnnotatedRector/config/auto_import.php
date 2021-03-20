<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use Rector\Core\Configuration\Option;
use Rector\Nette\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
};
