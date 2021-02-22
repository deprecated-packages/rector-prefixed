<?php

declare (strict_types=1);
namespace RectorPrefix20210222;

use Rector\Composer\Rector\ReplacePackageAndVersionComposerRector;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Rector\ReplacePackageAndVersionComposerRector::class)->call('configure', [[\Rector\Composer\Rector\ReplacePackageAndVersionComposerRector::REPLACE_PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\ReplacePackageAndVersion('vendor1/package1', 'vendor1/package3', '^4.0')])]]);
};
