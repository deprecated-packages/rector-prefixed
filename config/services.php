<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\Inflector;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\English\InflectorFactory;
use _PhpScoperb75b35f52b74\PhpParser\BuilderFactory;
use _PhpScoperb75b35f52b74\PhpParser\Lexer;
use _PhpScoperb75b35f52b74\PhpParser\NodeFinder;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\CloningVisitor;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use _PhpScoperb75b35f52b74\PhpParser\ParserFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\RectorClassesProvider;
use _PhpScoperb75b35f52b74\Rector\Core\Console\ConsoleApplication;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\NikicPhpParserFactory;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\PhpParserLexerFactory;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Application as SymfonyApplication;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoperb75b35f52b74\Symfony\Component\Filesystem\Filesystem;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Command\CommandNaming;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Strings\StringFormatConverter;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
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
    $services->alias(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Application::class, \_PhpScoperb75b35f52b74\Rector\Core\Console\ConsoleApplication::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\Bootstrap\NoRectorsLoadedReporter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Descriptor\TextDescriptor::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\ParserFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\BuilderFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\CloningVisitor::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\NodeFinder::class);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\Parser::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\NikicPhpParserFactory::class), 'create']);
    $services->set(\_PhpScoperb75b35f52b74\PhpParser\Lexer::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\PhpParserLexerFactory::class), 'create']);
    // symplify/package-builder
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Filesystem\Filesystem::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->arg('$container', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\RectorClassesProvider::class)->arg('$container', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('service_container'));
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Strings\StringFormatConverter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\English\InflectorFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Doctrine\Inflector\Inflector::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\English\InflectorFactory::class), 'build']);
};
