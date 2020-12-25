<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector;
use Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use Rector\Performance\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector::class);
    $services->set(\Rector\Performance\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector::class);
    $services->set(\Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class);
};
