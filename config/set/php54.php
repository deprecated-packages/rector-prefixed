<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use _PhpScoper0a6b37af0871\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['mysqli_param_count' => 'mysqli_stmt_param_count']]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector::class);
};
