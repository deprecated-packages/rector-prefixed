<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/rectorphp/rector/issues/1024 - no type, $dataName
        new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', '__construct', 2, new \_PhpScopere8e811afab72\PHPStan\Type\MixedType()),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/sebastianbergmann/phpunit/issues/3123
        'PHPUnit_Framework_MockObject_MockObject' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\MockObject',
    ]]]);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'setUpBeforeClass', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'setUp', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'assertPreConditions', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'assertPostConditions', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'tearDown', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'tearDownAfterClass', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'onNotSuccessfulTest', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType())])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector::class);
};
