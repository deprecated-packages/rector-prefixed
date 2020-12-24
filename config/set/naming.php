<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector::class);
};
