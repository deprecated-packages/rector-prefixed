<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector;
use _PhpScopere8e811afab72\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# @see https://www.tomasvotruba.cz/blog/2018/07/30/hidden-gems-of-php-packages-nette-utils
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('file_get_contents', '_PhpScopere8e811afab72\\Nette\\Utils\\FileSystem', 'read'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('unlink', '_PhpScopere8e811afab72\\Nette\\Utils\\FileSystem', 'delete'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('rmdir', '_PhpScopere8e811afab72\\Nette\\Utils\\FileSystem', 'delete')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector::class);
};
