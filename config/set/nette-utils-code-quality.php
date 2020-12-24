<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector;
use _PhpScoperb75b35f52b74\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# @see https://www.tomasvotruba.cz/blog/2018/07/30/hidden-gems-of-php-packages-nette-utils
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall('file_get_contents', '_PhpScoperb75b35f52b74\\Nette\\Utils\\FileSystem', 'read'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall('unlink', '_PhpScoperb75b35f52b74\\Nette\\Utils\\FileSystem', 'delete'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncCallToStaticCall('rmdir', '_PhpScoperb75b35f52b74\\Nette\\Utils\\FileSystem', 'delete')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\NotIdentical\StrposToStringsContainsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\SubstrStrlenFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\NetteUtilsCodeQuality\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector::class);
};
