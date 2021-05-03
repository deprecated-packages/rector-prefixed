<?php

declare (strict_types=1);
namespace RectorPrefix20210503;

use RectorPrefix20210503\Composer\Semver\VersionParser;
use RectorPrefix20210503\Doctrine\Inflector\Inflector;
use RectorPrefix20210503\Doctrine\Inflector\Rules\English\InflectorFactory;
use RectorPrefix20210503\Nette\Caching\Cache;
use PhpParser\BuilderFactory;
use PhpParser\Lexer;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitor\CloningVisitor;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\Dependency\DependencyResolver;
use PHPStan\File\FileHelper;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Reflection\ReflectionProvider;
use Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use Rector\BetterPhpDocParser\PhpDocParser\BetterTypeParser;
use Rector\Caching\Cache\NetteCacheFactory;
use Rector\Core\Console\ConsoleApplication;
use Rector\Core\NonPhpFile\Rector\RenameClassNonPhpRector;
use Rector\Core\PhpParser\Parser\NikicPhpParserFactory;
use Rector\Core\PhpParser\Parser\PhpParserLexerFactory;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocator\IntermediateSourceLocator;
use Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider;
use RectorPrefix20210503\Symfony\Component\Console\Application as SymfonyApplication;
use RectorPrefix20210503\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service;
use RectorPrefix20210503\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use RectorPrefix20210503\Symplify\PackageBuilder\Console\Command\CommandNaming;
use RectorPrefix20210503\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20210503\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210503\Symplify\PackageBuilder\Php\TypeChecker;
use RectorPrefix20210503\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210503\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use RectorPrefix20210503\Symplify\PackageBuilder\Strings\StringFormatConverter;
use RectorPrefix20210503\Symplify\SmartFileSystem\FileSystemFilter;
use RectorPrefix20210503\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20210503\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20210503\Symplify\SmartFileSystem\Json\JsonFileSystem;
use RectorPrefix20210503\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Core\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector', __DIR__ . '/../src/Exception', __DIR__ . '/../src/DependencyInjection/CompilerPass', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Bootstrap', __DIR__ . '/../src/PhpParser/Node/CustomNode', __DIR__ . '/../src/functions']);
    $services->alias(\RectorPrefix20210503\Symfony\Component\Console\Application::class, \Rector\Core\Console\ConsoleApplication::class);
    $services->set(\RectorPrefix20210503\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\RectorPrefix20210503\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser::class);
    $services->set(\PhpParser\ParserFactory::class);
    $services->set(\PhpParser\BuilderFactory::class);
    $services->set(\PhpParser\NodeVisitor\CloningVisitor::class);
    $services->set(\PhpParser\NodeFinder::class);
    $services->set(\PhpParser\Parser::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Core\PhpParser\Parser\NikicPhpParserFactory::class), 'create']);
    $services->set(\PhpParser\Lexer::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Core\PhpParser\Parser\PhpParserLexerFactory::class), 'create']);
    // symplify/package-builder
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\RectorPrefix20210503\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\RectorPrefix20210503\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->arg('$container', \RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container'));
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\RectorPrefix20210503\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Strings\StringFormatConverter::class);
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20210503\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210503\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\RectorPrefix20210503\Symplify\SmartFileSystem\Json\JsonFileSystem::class);
    $services->set(\PhpParser\NodeVisitor\NodeConnectingVisitor::class);
    $services->set(\RectorPrefix20210503\Doctrine\Inflector\Rules\English\InflectorFactory::class);
    $services->set(\RectorPrefix20210503\Doctrine\Inflector\Inflector::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210503\Doctrine\Inflector\Rules\English\InflectorFactory::class), 'build']);
    $services->set(\RectorPrefix20210503\Composer\Semver\VersionParser::class);
    $services->set(\RectorPrefix20210503\Symplify\PackageBuilder\Php\TypeChecker::class);
    // phpdoc parser
    $services->set(\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->alias(\PHPStan\PhpDocParser\Parser\PhpDocParser::class, \Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser::class);
    // cache
    $services->set(\PHPStan\Dependency\DependencyResolver::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\PHPStan\File\FileHelper::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\RectorPrefix20210503\Nette\Caching\Cache::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Caching\Cache\NetteCacheFactory::class), 'create']);
    // type resolving
    $services->set(\Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocator\IntermediateSourceLocator::class);
    $services->alias(\PHPStan\PhpDocParser\Parser\TypeParser::class, \Rector\BetterPhpDocParser\PhpDocParser\BetterTypeParser::class);
    // non php changes
    $services->set(\Rector\Core\NonPhpFile\Rector\RenameClassNonPhpRector::class);
    // PHPStan services
    $services->set(\PHPStan\Reflection\ReflectionProvider::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createReflectionProvider']);
    $services->set(\PHPStan\Analyser\NodeScopeResolver::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createNodeScopeResolver']);
    $services->set(\PHPStan\Analyser\ScopeFactory::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createScopeFactory']);
    $services->set(\PHPStan\PhpDoc\TypeNodeResolver::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createTypeNodeResolver']);
    $services->set(\Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider::class)->factory([\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDynamicSourceLocatorProvider']);
};
