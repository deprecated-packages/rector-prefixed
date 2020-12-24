<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\WrapReturn;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/pull/28447
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\NewToStaticCall('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\Cookie', '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\Cookie', 'create')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/symfony/symfony/commit/a7e319d9e1316e2e18843f8ce15b67a8693e5bf9
        '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller' => '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController',
        # https://github.com/symfony/symfony/commit/744bf0e7ac3ecf240d0bf055cc58f881bb0b3ec0
        '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerAwareCommand' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Command\\Command',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Translation\\TranslatorInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Contracts\\Translation\\TranslatorInterface',
    ]]]);
    # related to "Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand" deprecation, see https://github.com/rectorphp/rector/issues/1629
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    # https://symfony.com/blog/new-in-symfony-4-2-important-deprecations
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\New_\StringToArrayArgumentProcessRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\New_\RootNodeTreeBuilderRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/fa2063efe43109aea093d6fbfc12d675dba82146
        // https://github.com/symfony/symfony/commit/e3aa90f852f69040be19da3d8729cdf02d238ec7
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\BrowserKit\\Client', 'submit', 2, 'serverParameters', [], null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\DomCrawler\\Crawler', 'children', 0, null, null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\Finder\\Finder', 'sortByName', 0, null, \false, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'getLogs', 0, null, null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Processor\\DebugProcessor', 'countErrors', 0, 'default_value', null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'getLogs', 0, 'default_value', null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'countErrors', 0, 'default_value', null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 1, null, null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\Serializer\\Normalizer', 'handleCircularReference', 2, null, null, null, \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::SCOPE_METHOD_CALL),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\CacheItem', 'getPreviousTags', 'getMetadata'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedType', 'getExtendedTypes')])]]);
    $iterableType = new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', $iterableType)])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', 'static')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\WrapReturn('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractTypeExtension', 'getExtendedTypes', \true)])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[
        // https://github.com/symfony/symfony/commit/9493cfd5f2366dab19bbdde0d0291d0575454567
        \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 5, \false, null), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\Cookie', '__construct', 8, null, 'lax')]),
    ]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[
        # https://github.com/symfony/symfony/commit/f5c355e1ba399a1b3512367647d902148bdaf09f
        \_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 0, null), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\DataCollector\\ConfigDataCollector', '__construct', 1, null)]),
    ]]);
};
