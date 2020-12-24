<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use _PhpScoperb75b35f52b74\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use _PhpScoperb75b35f52b74\Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use _PhpScoperb75b35f52b74\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);
};
