<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Yaml\Parser;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
