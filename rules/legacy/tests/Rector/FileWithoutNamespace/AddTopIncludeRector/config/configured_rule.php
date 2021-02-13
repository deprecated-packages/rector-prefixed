<?php

namespace RectorPrefix20210213;

use Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::class)->call('configure', [[\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::AUTOLOAD_FILE_PATH => '/../autoloader.php']]);
};
