<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/rectorphp/rector/issues/1024 - no type, $dataName
        new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', '__construct', 2, new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType()),
    ])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/sebastianbergmann/phpunit/issues/3123
        'PHPUnit_Framework_MockObject_MockObject' => '_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\MockObject\\MockObject',
    ]]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'setUpBeforeClass', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'setUp', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'assertPreConditions', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'assertPostConditions', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'tearDown', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'tearDownAfterClass', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'onNotSuccessfulTest', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType())])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector::class);
};
