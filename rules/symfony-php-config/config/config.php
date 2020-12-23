<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Parser;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
