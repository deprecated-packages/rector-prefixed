<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $inlinedValueObjects = \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn(\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType::class, 'process', 'getNodeTypes')]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => $inlinedValueObjects]]);
};
