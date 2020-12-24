<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PhpParser\BuilderFactory;
use _PhpScoperb75b35f52b74\PhpParser\NodeFinder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symfony\Component\Yaml\Parser;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
