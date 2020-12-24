<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;
use _PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# source: https://carbon.nesbot.com/docs/#api-carbon-2
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector::class);
};
