<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector::class);
};
