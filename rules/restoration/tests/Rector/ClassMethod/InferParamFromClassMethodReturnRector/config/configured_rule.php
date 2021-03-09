<?php

declare (strict_types=1);
namespace RectorPrefix20210309;

use Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector;
use Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType;
use Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $configuration = \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Restoration\ValueObject\InferParamFromClassMethodReturn(\Rector\Restoration\Tests\Rector\ClassMethod\InferParamFromClassMethodReturnRector\Source\SomeType::class, 'process', 'getNodeTypes')]);
    $services->set(\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::class)->call('configure', [[\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => $configuration]]);
};
