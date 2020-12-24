<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScoperb75b35f52b74\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use _PhpScoperb75b35f52b74\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
    $services->alias(\_PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \_PhpScoperb75b35f52b74\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source\DummyPSR4AutoloadWithoutNamespaceMatcher::class);
};
