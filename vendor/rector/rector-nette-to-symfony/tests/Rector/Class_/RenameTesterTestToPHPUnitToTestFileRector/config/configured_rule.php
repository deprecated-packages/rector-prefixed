<?php

declare (strict_types=1);
namespace RectorPrefix20210509;

use Rector\Core\Configuration\Option;
use Rector\NetteToSymfony\Rector\Class_\RenameTesterTestToPHPUnitToTestFileRector;
use RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::FILE_EXTENSIONS, ['php', 'phpt']);
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\Class_\RenameTesterTestToPHPUnitToTestFileRector::class);
};
