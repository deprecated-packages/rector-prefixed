<?php

declare (strict_types=1);
namespace RectorPrefix20210207;

use RectorPrefix20210207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210207\Symfony\Component\Yaml\Parser;
use RectorPrefix20210207\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use RectorPrefix20210207\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\RectorPrefix20210207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\RectorPrefix20210207\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\RectorPrefix20210207\Symfony\Component\Yaml\Parser::class);
    $services->set(\RectorPrefix20210207\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
