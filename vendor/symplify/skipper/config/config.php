<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use _PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option::SKIP, []);
    $parameters->set(\_PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option::ONLY, []);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\Skipper\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer::class);
};
