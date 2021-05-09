<?php

declare (strict_types=1);
namespace RectorPrefix20210509;

use Rector\NetteToSymfony\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector;
use RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector::class);
};
