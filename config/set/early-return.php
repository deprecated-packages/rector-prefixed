<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Rector\SOLID\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\SOLID\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\SOLID\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\SOLID\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\SOLID\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector::class);
    $services->set(\Rector\SOLID\Rector\If_\ChangeAndIfToEarlyReturnRector::class);
    $services->set(\Rector\SOLID\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
    $services->set(\Rector\SOLID\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class);
};
