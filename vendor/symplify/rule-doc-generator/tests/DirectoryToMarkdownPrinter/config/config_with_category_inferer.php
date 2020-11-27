<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source\SimpleCategoryInferer::class);
};
