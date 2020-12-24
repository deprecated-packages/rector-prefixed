<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Doctrine\Inflector\Inflector;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\English\InflectorFactory;
use _PhpScopere8e811afab72\PhpParser\BuilderFactory;
use _PhpScopere8e811afab72\PhpParser\Lexer;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor\CloningVisitor;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\PhpParser\ParserFactory;
use _PhpScopere8e811afab72\Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use _PhpScopere8e811afab72\Rector\Core\Configuration\RectorClassesProvider;
use _PhpScopere8e811afab72\Rector\Core\Console\ConsoleApplication;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\NikicPhpParserFactory;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\PhpParserLexerFactory;
use _PhpScopere8e811afab72\Symfony\Component\Console\Application as SymfonyApplication;
use _PhpScopere8e811afab72\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScopere8e811afab72\Symfony\Component\Filesystem\Filesystem;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Command\CommandNaming;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Strings\StringFormatConverter;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Core\\', __DIR__ . '/../src')->exclude([
        __DIR__ . '/../src/Rector',
        __DIR__ . '/../src/Exception',
        __DIR__ . '/../src/DependencyInjection/CompilerPass',
        __DIR__ . '/../src/DependencyInjection/Loader',
        __DIR__ . '/../src/PhpParser/Builder',
        __DIR__ . '/../src/HttpKernel',
        __DIR__ . '/../src/ValueObject',
        __DIR__ . '/../src/Bootstrap',
        __DIR__ . '/../src/PhpParser/Node/CustomNode',
        // loaded for PHPStan factory
        __DIR__ . '/../src/PHPStan/Type',
    ]);
    $services->alias(\_PhpScopere8e811afab72\Symfony\Component\Console\Application::class, \_PhpScopere8e811afab72\Rector\Core\Console\ConsoleApplication::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Core\Bootstrap\NoRectorsLoadedReporter::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Console\Descriptor\TextDescriptor::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\ParserFactory::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\NodeVisitor\CloningVisitor::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\NodeFinder::class);
    $services->set(\_PhpScopere8e811afab72\PhpParser\Parser::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\NikicPhpParserFactory::class), 'create']);
    $services->set(\_PhpScopere8e811afab72\PhpParser\Lexer::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\PhpParserLexerFactory::class), 'create']);
    // symplify/package-builder
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Filesystem\Filesystem::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->arg('$container', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\RectorClassesProvider::class)->arg('$container', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Strings\StringFormatConverter::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\English\InflectorFactory::class);
    $services->set(\_PhpScopere8e811afab72\Doctrine\Inflector\Inflector::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\English\InflectorFactory::class), 'build']);
};
