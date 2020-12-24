<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Php72\Rector\Assign\ListEachRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\Unset_\UnsetCastRector;
use _PhpScopere8e811afab72\Rector\Php72\Rector\While_\WhileEachToForeachRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\While_\WhileEachToForeachRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\Assign\ListEachRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\Unset_\UnsetCastRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
        # and imagewbmp
        'jpeg2wbmp' => 'imagecreatefromjpeg',
        # or imagewbmp
        'png2wbmp' => 'imagecreatefrompng',
        #migration72.deprecated.gmp_random-function
        # http://php.net/manual/en/migration72.deprecated.php
        # or gmp_random_range
        'gmp_random' => 'gmp_random_bits',
        'read_exif_data' => 'exif_read_data',
    ]]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\GetClassOnNullRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\StringsAssertNakedRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\StringifyDefineRector::class);
};
