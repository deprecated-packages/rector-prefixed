<?php

declare (strict_types=1);
namespace RectorPrefix20210222;

use RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210222\Symfony\Component\Yaml\Parser;
use RectorPrefix20210222\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use RectorPrefix20210222\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\RectorPrefix20210222\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\RectorPrefix20210222\Symfony\Component\Yaml\Parser::class);
    $services->set(\RectorPrefix20210222\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
