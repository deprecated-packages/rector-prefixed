<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer::class);
};
