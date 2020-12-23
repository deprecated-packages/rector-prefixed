<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector;
use _PhpScoper0a2ac50786fa\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector::class);
};
