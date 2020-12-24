<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\FileSystem\FilesFinder;
use _PhpScoper0a6b37af0871\Rector\Core\Php\TypeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
