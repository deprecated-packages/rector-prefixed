<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector::class);
};
