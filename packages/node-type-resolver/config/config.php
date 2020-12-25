<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Core\Configuration\Option;
use Rector\Core\FileSystem\FilesFinder;
use Rector\Core\Php\TypeAnalyzer;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHPSTAN_FOR_RECTOR_PATH, \getcwd() . '/phpstan-for-rector.neon');
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeTypeResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract', __DIR__ . '/../src/PHPStan/TypeExtension']);
    $services->set(\Rector\Core\Php\TypeAnalyzer::class);
    $services->set(\Rector\Core\FileSystem\FilesFinder::class);
    $services->set(\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    $services->set(\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    $services->set(\PHPStan\Reflection\ReflectionProvider::class)->factory([\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\PHPStan\Analyser\NodeScopeResolver::class)->factory([\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\PHPStan\Analyser\ScopeFactory::class)->factory([\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
};
