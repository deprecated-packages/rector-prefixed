<?php

declare (strict_types=1);
namespace RectorPrefix20210318;

use RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\', __DIR__ . '/../packages')->exclude([
        // @todo move to value object
        __DIR__ . '/../packages/*/{ValueObject,Contract,Exception}',
        __DIR__ . '/../packages/AttributeAwarePhpDoc/Ast',
        __DIR__ . '/../packages/BetterPhpDocParser/Attributes/Ast/PhpDoc',
        __DIR__ . '/../packages/BetterPhpDocParser/Attributes/Attribute',
        __DIR__ . '/../packages/BetterPhpDocParser/PhpDocInfo/PhpDocInfo.php',
        __DIR__ . '/../packages/Testing/PHPUnit',
        __DIR__ . '/../packages/Testing/PhpConfigPrinter/YamlFileContentProvider.php',
        __DIR__ . '/../packages/Testing/PhpConfigPrinter/SymfonyVersionFeatureGuard.php',
        // used in PHPStan
        __DIR__ . '/../packages/NodeTypeResolver/Reflection/BetterReflection/RectorBetterReflectionSourceLocatorFactory.php',
        __DIR__ . '/../packages/NodeTypeResolver/Reflection/BetterReflection/SourceLocatorProvider/DynamicSourceLocatorProvider.php',
    ]);
};
