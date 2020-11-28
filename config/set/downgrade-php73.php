<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector;
use Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector;
use Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector::class);
    $services->set(\Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector::class);
    $services->set(\Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector::class)->call('configure', [[\Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector::TARGET_PHP_VERSION => 70300]]);
};
