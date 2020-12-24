<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', 'put', new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', 'forever', new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', 'put', new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', 'putMany', new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', 'forever', new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType())])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty('_PhpScopere8e811afab72\\Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector::class);
};
