<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use _PhpScoper0a2ac50786fa\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Cache\\Repository', 'put', new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Cache\\Repository', 'forever', new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Cache\\Store', 'put', new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Cache\\Store', 'putMany', new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Illuminate\\Contracts\\Cache\\Store', 'forever', new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType())])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameProperty('_PhpScoper0a2ac50786fa\\Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector::class);
};
