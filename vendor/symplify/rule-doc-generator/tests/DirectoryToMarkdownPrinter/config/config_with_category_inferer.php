<?php

declare (strict_types=1);
namespace RectorPrefix20210129;

use RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer;
return static function (\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer::class);
};
