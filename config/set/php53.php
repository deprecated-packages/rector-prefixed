<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use _PhpScoper0a6b37af0871\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use _PhpScoper0a6b37af0871\Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use _PhpScoper0a6b37af0871\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);
};
