<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['mysqli_param_count' => 'mysqli_stmt_param_count']]]);
    $services->set(\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class);
    $services->set(\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class);
};
