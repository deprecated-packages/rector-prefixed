<?php

declare (strict_types=1);
namespace RectorPrefix20210316;

use RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210316\Symplify\ComposerJsonManipulator\ValueObject\Option;
use RectorPrefix20210316\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210316\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use RectorPrefix20210316\Symplify\SmartFileSystem\SmartFileSystem;
use function RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210316\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210316\Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\RectorPrefix20210316\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\RectorPrefix20210316\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\RectorPrefix20210316\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
