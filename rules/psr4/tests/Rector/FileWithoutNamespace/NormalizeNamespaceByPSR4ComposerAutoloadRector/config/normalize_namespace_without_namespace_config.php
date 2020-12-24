<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScopere8e811afab72\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use _PhpScopere8e811afab72\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
    $services->alias(\_PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \_PhpScopere8e811afab72\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
};
