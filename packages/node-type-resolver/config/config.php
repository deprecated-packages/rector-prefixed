<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\FileSystem\FilesFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\Php\TypeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
