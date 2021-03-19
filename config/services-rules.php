<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Core\Configuration\Option;
use Rector\PSR4\Composer\PSR4NamespaceMatcher;
use Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210319\Symfony\Component\Yaml\Parser;
use RectorPrefix20210319\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM, []);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // psr-4
    $services->alias(\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \Rector\PSR4\Composer\PSR4NamespaceMatcher::class);
    $services->load('Rector\\', __DIR__ . '/../rules')->exclude([__DIR__ . '/../rules/*/{ValueObject,Rector,Contract,Exception}']);
    // symfony code-quality
    $services->set(\RectorPrefix20210319\Symfony\Component\Yaml\Parser::class);
    $services->set(\RectorPrefix20210319\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter::class);
};
