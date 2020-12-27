<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use Rector\Generic\ValueObject\ArgumentRemover;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\Generic\ValueObject\WrapReturn;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector;
use Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector;
use Rector\Transform\Rector\New_\NewToStaticCallRector;
use Rector\Transform\ValueObject\NewToStaticCall;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/pull/28447
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\New_\NewToStaticCallRector::class)->call('configure', [[\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\NewToStaticCall('RectorPrefix20201227\\Symfony\\Component\\HttpFoundation\\Cookie', 'RectorPrefix20201227\\Symfony\\Component\\HttpFoundation\\Cookie', 'create')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/symfony/symfony/commit/a7e319d9e1316e2e18843f8ce15b67a8693e5bf9
        'RectorPrefix20201227\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller' => 'RectorPrefix20201227\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController',
        # https://github.com/symfony/symfony/commit/744bf0e7ac3ecf240d0bf055cc58f881bb0b3ec0
        'RectorPrefix20201227\\Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerAwareCommand' => 'RectorPrefix20201227\\Symfony\\Component\\Console\\Command\\Command',
        'RectorPrefix20201227\\Symfony\\Component\\Translation\\TranslatorInterface' => 'RectorPrefix20201227\\Symfony\\Contracts\\Translation\\TranslatorInterface',
    ]]]);
    # related to "Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand" deprecation, see https://github.com/rectorphp/rector/issues/1629
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    # https://symfony.com/blog/new-in-symfony-4-2-important-deprecations
    $services->set(\Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector::class);
    $services->set(\Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector::class);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/fa2063efe43109aea093d6fbfc12d675dba82146
        // https://github.com/symfony/symfony/commit/e3aa90f852f69040be19da3d8729cdf02d238ec7
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Component\\BrowserKit\\Client', 'submit', 2, 'serverParameters', [], null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Component\\DomCrawler\\Crawler', 'children', 0, null, null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Component\\Finder\\Finder', 'sortByName', 0, null, \false, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'getLogs', 0, null, null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'countErrors', 0, 'default_value', null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Bridge\\Monolog\\Logger', 'getLogs', 0, 'default_value', null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Bridge\\Monolog\\Logger', 'countErrors', 0, 'default_value', null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 1, null, null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201227\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 2, null, null, null, \Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
    ])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Symfony\\Component\\Cache\\CacheItem', 'getPreviousTags', 'getMetadata'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedType', 'getExtendedTypes')])]]);
    $iterableType = new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('RectorPrefix20201227\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', $iterableType)])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('RectorPrefix20201227\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', \Rector\Core\ValueObject\Visibility::STATIC)])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\WrapReturn('RectorPrefix20201227\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', \true)])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[
        // https://github.com/symfony/symfony/commit/9493cfd5f2366dab19bbdde0d0291d0575454567
        \Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix20201227\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 5, \false, null), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix20201227\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 8, null, 'lax')]),
    ]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[
        # https://github.com/symfony/symfony/commit/f5c355e1ba399a1b3512367647d902148bdaf09f
        \Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentRemover('RectorPrefix20201227\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 0, null), new \Rector\Generic\ValueObject\ArgumentRemover('RectorPrefix20201227\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 1, null)]),
    ]]);
};
