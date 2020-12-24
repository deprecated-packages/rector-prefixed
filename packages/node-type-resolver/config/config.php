<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\FileSystem\FilesFinder;
use _PhpScoperb75b35f52b74\Rector\Core\Php\TypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
