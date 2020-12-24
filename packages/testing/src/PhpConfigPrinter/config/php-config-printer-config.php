<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard;
use _PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->alias(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\SymfonyVersionFeatureGuard::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
    $services->alias(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter\YamlFileContentProvider::class);
};
