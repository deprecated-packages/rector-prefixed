<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector;
use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\English\InflectorFactory;
use _PhpScoper0a6b37af0871\PhpParser\BuilderFactory;
use _PhpScoper0a6b37af0871\PhpParser\Lexer;
use _PhpScoper0a6b37af0871\PhpParser\NodeFinder;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor\CloningVisitor;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\PhpParser\ParserFactory;
use _PhpScoper0a6b37af0871\Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\RectorClassesProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Console\ConsoleApplication;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\NikicPhpParserFactory;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\PhpParserLexerFactory;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Application as SymfonyApplication;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoper0a6b37af0871\Symfony\Component\Filesystem\Filesystem;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Command\CommandNaming;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Strings\StringFormatConverter;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
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
    $services->alias(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Application::class, \_PhpScoper0a6b37af0871\Rector\Core\Console\ConsoleApplication::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\Bootstrap\NoRectorsLoadedReporter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Descriptor\TextDescriptor::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\ParserFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\NodeVisitor\CloningVisitor::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\Parser::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\NikicPhpParserFactory::class), 'create']);
    $services->set(\_PhpScoper0a6b37af0871\PhpParser\Lexer::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\PhpParserLexerFactory::class), 'create']);
    // symplify/package-builder
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Filesystem\Filesystem::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->arg('$container', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\RectorClassesProvider::class)->arg('$container', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Strings\StringFormatConverter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\English\InflectorFactory::class);
    $services->set(\_PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\English\InflectorFactory::class), 'build']);
};
