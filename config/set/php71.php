<?php

declare (strict_types=1);
namespace RectorPrefix20210503;

use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php71\Rector\List_\ListToArrayDestructRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php71\Rector\BooleanOr\IsIterableRector::class);
    $services->set(\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector::class);
    $services->set(\Rector\Php71\Rector\Assign\AssignArrayToStringRector::class);
    $services->set(\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
    $services->set(\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class);
    $services->set(\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class);
    $services->set(\Rector\Php71\Rector\List_\ListToArrayDestructRector::class);
};
