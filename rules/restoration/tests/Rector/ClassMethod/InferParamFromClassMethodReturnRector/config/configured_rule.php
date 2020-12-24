<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector;
use _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType;
use _PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $inlinedValueObjects = \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\InferParamFromClassMethodReturn(\_PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType::class, 'process', 'getNodeTypes')]);
    $services->set(\_PhpScopere8e811afab72\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => $inlinedValueObjects]]);
};
