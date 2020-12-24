<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Cache\\Repository', 'put', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Cache\\Repository', 'forever', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Cache\\Store', 'put', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Cache\\Store', 'putMany', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Cache\\Store', 'forever', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType())])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector::class);
};
