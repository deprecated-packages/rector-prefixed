<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;
use _PhpScopere8e811afab72\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# source: https://carbon.nesbot.com/docs/#api-carbon-2
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector::class);
};
