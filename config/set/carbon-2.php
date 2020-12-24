<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;
use _PhpScoperb75b35f52b74\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# source: https://carbon.nesbot.com/docs/#api-carbon-2
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector::class);
};
