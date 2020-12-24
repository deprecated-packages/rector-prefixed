<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
};
