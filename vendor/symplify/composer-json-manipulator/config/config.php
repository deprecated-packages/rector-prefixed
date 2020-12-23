<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
