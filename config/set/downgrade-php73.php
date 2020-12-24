<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector::class);
};
