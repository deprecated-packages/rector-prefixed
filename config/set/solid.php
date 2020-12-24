<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class);
};
