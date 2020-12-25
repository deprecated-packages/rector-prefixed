<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
    $services->set(\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
    $services->set(\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
    $services->set(\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);
};
