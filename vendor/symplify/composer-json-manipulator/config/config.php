<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
