<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector;
use _PhpScoper0a6b37af0871\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# @see https://www.tomasvotruba.cz/blog/2018/07/30/hidden-gems-of-php-packages-nette-utils
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall('file_get_contents', '_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'read'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall('unlink', '_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'delete'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncCallToStaticCall('rmdir', '_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'delete')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector::class);
};
