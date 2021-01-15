<?php

declare (strict_types=1);
namespace RectorPrefix20210115;

use Rector\Composer\Modifier\ComposerModifier;
use Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion;
use RectorPrefix20210115\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210115\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Composer\Modifier\ComposerModifier::class)->call('setFilePath', [__DIR__ . '/../Fixture/composer_before.json'])->call('configure', [\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Composer\ValueObject\ComposerModifier\ChangePackageVersion('nette/nette', '^3.0')])]);
};
