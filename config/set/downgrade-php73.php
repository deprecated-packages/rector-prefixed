<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector;
use Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector;
use Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector;
use Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector::class);
    $services->set(\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector::class);
    $services->set(\Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector::class);
    $services->set(\Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector::class);
};
