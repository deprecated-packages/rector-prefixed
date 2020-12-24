<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class);
};
