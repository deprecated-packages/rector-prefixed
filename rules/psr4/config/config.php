<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PSR4\Composer\PSR4NamespaceMatcher;
use _PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\PSR4\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\_PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface::class, \_PhpScoperb75b35f52b74\Rector\PSR4\Composer\PSR4NamespaceMatcher::class);
};
