<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symfony\Component\Yaml\Parser;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
