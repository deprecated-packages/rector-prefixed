<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\Core\Configuration\Option;
use Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $services = $containerConfigurator->services();
    $services->set(\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector::class);
    $services->set(\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
    $services->alias(\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
};
