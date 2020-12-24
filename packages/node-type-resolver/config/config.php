<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\FileSystem\FilesFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Php\TypeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::PHPSTAN_FOR_RECTOR_PATH, \getcwd() . '/phpstan-for-rector.neon');
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
