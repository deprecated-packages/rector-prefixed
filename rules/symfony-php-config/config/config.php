<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symfony\Component\Yaml\Parser;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
