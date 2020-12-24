<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\BinaryOp\IsIterableRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\CountOnNullRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\List_\ListToArrayDestructRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\Name\ReservedObjectRector;
use _PhpScoperb75b35f52b74\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\BinaryOp\IsIterableRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\Name\ReservedObjectRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Php71\Rector\Name\ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => ['Object' => 'BaseObject']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\Assign\AssignArrayToStringRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php71\Rector\List_\ListToArrayDestructRector::class);
};
