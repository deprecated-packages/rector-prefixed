<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver;
use _PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\Rector\Core\FileSystem\FilesFinder;
use _PhpScopere8e811afab72\Rector\Core\Php\TypeAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\_PhpScopere8e811afab72\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\_PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\_PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\_PhpScopere8e811afab72\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
