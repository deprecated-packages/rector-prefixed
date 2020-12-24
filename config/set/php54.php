<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['mysqli_param_count' => 'mysqli_stmt_param_count']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class);
};
