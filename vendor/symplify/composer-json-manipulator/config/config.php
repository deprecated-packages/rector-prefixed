<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem;
use function _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
