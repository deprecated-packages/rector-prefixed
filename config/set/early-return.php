<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector::class);
};
