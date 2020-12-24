<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\BinaryOp\IsIterableRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\CountOnNullRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\List_\ListToArrayDestructRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\Name\ReservedObjectRector;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\BinaryOp\IsIterableRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\Name\ReservedObjectRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Php71\Rector\Name\ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => ['Object' => 'BaseObject']]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\Assign\AssignArrayToStringRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php71\Rector\List_\ListToArrayDestructRector::class);
};
