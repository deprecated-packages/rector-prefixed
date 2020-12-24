<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# @see https://www.tomasvotruba.cz/blog/2018/07/30/hidden-gems-of-php-packages-nette-utils
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncCallToStaticCall('file_get_contents', '_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\FileSystem', 'read'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncCallToStaticCall('unlink', '_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\FileSystem', 'delete'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncCallToStaticCall('rmdir', '_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\FileSystem', 'delete')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector::class);
};
