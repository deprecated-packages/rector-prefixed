<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use _PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option::SKIP, []);
    $parameters->set(\_PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option::ONLY, []);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\Skipper\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Normalizer\PathNormalizer::class);
};
