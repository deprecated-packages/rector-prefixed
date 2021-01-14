<?php

declare (strict_types=1);
namespace RectorPrefix20210114;

use RectorPrefix20210114\Composer\Semver\VersionParser;
use RectorPrefix20210114\Doctrine\Inflector\Inflector;
use RectorPrefix20210114\Doctrine\Inflector\Rules\English\InflectorFactory;
use PhpParser\BuilderFactory;
use PhpParser\Lexer;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitor\CloningVisitor;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use Rector\Core\Configuration\RectorClassesProvider;
use Rector\Core\Console\ConsoleApplication;
use Rector\Core\PhpParser\Parser\NikicPhpParserFactory;
use Rector\Core\PhpParser\Parser\PhpParserLexerFactory;
use RectorPrefix20210114\Symfony\Component\Console\Application as SymfonyApplication;
use RectorPrefix20210114\Symfony\Component\Console\Descriptor\TextDescriptor;
use RectorPrefix20210114\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service;
use RectorPrefix20210114\Symfony\Component\Filesystem\Filesystem;
use RectorPrefix20210114\Symplify\PackageBuilder\Console\Command\CommandNaming;
use RectorPrefix20210114\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20210114\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210114\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210114\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use RectorPrefix20210114\Symplify\PackageBuilder\Strings\StringFormatConverter;
use RectorPrefix20210114\Symplify\SmartFileSystem\FileSystemFilter;
use RectorPrefix20210114\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Core\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector', __DIR__ . '/../src/Exception', __DIR__ . '/../src/DependencyInjection/CompilerPass', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/Bootstrap', __DIR__ . '/../src/PhpParser/Node/CustomNode']);
    $services->alias(\RectorPrefix20210114\Symfony\Component\Console\Application::class, \Rector\Core\Console\ConsoleApplication::class);
    $services->set(\Rector\Core\Bootstrap\NoRectorsLoadedReporter::class);
    $services->set(\RectorPrefix20210114\Symfony\Component\Console\Descriptor\TextDescriptor::class);
    $services->set(\PhpParser\ParserFactory::class);
    $services->set(\PhpParser\BuilderFactory::class);
    $services->set(\PhpParser\NodeVisitor\CloningVisitor::class);
    $services->set(\PhpParser\NodeFinder::class);
    $services->set(\PhpParser\Parser::class)->factory([\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Core\PhpParser\Parser\NikicPhpParserFactory::class), 'create']);
    $services->set(\PhpParser\Lexer::class)->factory([\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Core\PhpParser\Parser\PhpParserLexerFactory::class), 'create']);
    // symplify/package-builder
    $services->set(\RectorPrefix20210114\Symfony\Component\Filesystem\Filesystem::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\RectorPrefix20210114\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\RectorPrefix20210114\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->arg('$container', \RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container'));
    $services->set(\Rector\Core\Configuration\RectorClassesProvider::class)->arg('$container', \RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container'));
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Strings\StringFormatConverter::class);
    $services->set(\RectorPrefix20210114\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20210114\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210114\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\RectorPrefix20210114\Doctrine\Inflector\Rules\English\InflectorFactory::class);
    $services->set(\RectorPrefix20210114\Doctrine\Inflector\Inflector::class)->factory([\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210114\Doctrine\Inflector\Rules\English\InflectorFactory::class), 'build']);
    $services->set(\RectorPrefix20210114\Composer\Semver\VersionParser::class);
};
