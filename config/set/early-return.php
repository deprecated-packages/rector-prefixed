<?php

declare (strict_types=1);
namespace RectorPrefix20210127;

use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
    $services->set(\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class);
    $services->set(\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector::class);
    $services->set(\Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector::class);
};
