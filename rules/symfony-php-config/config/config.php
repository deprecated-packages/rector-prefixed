<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symfony\Component\Yaml\Parser;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\YamlToPhpConverter;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\SymfonyPhpConfig\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->set(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
