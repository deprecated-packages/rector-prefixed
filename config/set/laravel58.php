<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Cache\\Repository', 'put', new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Cache\\Repository', 'forever', new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Cache\\Store', 'put', new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Cache\\Store', 'putMany', new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Cache\\Store', 'forever', new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType())])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty('_PhpScoperb75b35f52b74\\Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector::class);
};
