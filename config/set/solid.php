<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class);
};
