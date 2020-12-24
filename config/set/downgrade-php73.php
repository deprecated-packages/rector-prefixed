<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector::class);
};
