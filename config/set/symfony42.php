<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector;
use _PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/pull/28447
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall('_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Cookie', '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Cookie', 'create')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/symfony/symfony/commit/a7e319d9e1316e2e18843f8ce15b67a8693e5bf9
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller' => '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController',
        # https://github.com/symfony/symfony/commit/744bf0e7ac3ecf240d0bf055cc58f881bb0b3ec0
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerAwareCommand' => '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Command\\Command',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Translation\\TranslatorInterface' => '_PhpScopere8e811afab72\\Symfony\\Contracts\\Translation\\TranslatorInterface',
    ]]]);
    # related to "Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand" deprecation, see https://github.com/rectorphp/rector/issues/1629
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    # https://symfony.com/blog/new-in-symfony-4-2-important-deprecations
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/fa2063efe43109aea093d6fbfc12d675dba82146
        // https://github.com/symfony/symfony/commit/e3aa90f852f69040be19da3d8729cdf02d238ec7
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\BrowserKit\\Client', 'submit', 2, 'serverParameters', [], null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\DomCrawler\\Crawler', 'children', 0, null, null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\Finder\\Finder', 'sortByName', 0, null, \false, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'getLogs', 0, null, null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'countErrors', 0, 'default_value', null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'getLogs', 0, 'default_value', null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'countErrors', 0, 'default_value', null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 1, null, null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 2, null, null, null, \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\CacheItem', 'getPreviousTags', 'getMetadata'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedType', 'getExtendedTypes')])]]);
    $iterableType = new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', $iterableType)])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', 'static')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', \true)])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[
        // https://github.com/symfony/symfony/commit/9493cfd5f2366dab19bbdde0d0291d0575454567
        \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 5, \false, null), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 8, null, 'lax')]),
    ]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[
        # https://github.com/symfony/symfony/commit/f5c355e1ba399a1b3512367647d902148bdaf09f
        \_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 0, null), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 1, null)]),
    ]]);
};
