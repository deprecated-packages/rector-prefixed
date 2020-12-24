<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Cache\\Repository', 'put', new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Cache\\Repository', 'forever', new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Cache\\Store', 'put', new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Cache\\Store', 'putMany', new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Cache\\Store', 'forever', new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType())])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty('_PhpScoper0a6b37af0871\\Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector::class);
};
