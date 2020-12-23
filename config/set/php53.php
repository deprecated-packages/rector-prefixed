<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use _PhpScoper0a2ac50786fa\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use _PhpScoper0a2ac50786fa\Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use _PhpScoper0a2ac50786fa\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);
};
