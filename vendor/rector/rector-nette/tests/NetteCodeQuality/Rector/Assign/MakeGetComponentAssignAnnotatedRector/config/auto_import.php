<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Core\Configuration\Option;
use Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
};
