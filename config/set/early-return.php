<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector::class);
};
