<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Class_\ClassConstantToSelfClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Double\RealToFloatTypeCastRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Function_\ReservedFnFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Property\TypedPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
        #the_real_type
        # https://wiki.php.net/rfc/deprecations_php_7_4
        'is_real' => 'is_float',
        #apache_request_headers_function
        # https://wiki.php.net/rfc/deprecations_php_7_4
        'apache_request_headers' => 'getallheaders',
    ]]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Class_\ClassConstantToSelfClassRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Double\RealToFloatTypeCastRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class);
};
