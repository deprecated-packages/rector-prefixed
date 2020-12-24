<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::SKIP, []);
    $parameters->set(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::ONLY, []);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\Skipper\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Normalizer\PathNormalizer::class);
};
