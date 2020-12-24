<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
