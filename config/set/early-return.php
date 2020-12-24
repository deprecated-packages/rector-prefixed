<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use _PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector::class);
};
