<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/rectorphp/rector/issues/1024 - no type, $dataName
        new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', '__construct', 2, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType()),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertInternalTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/sebastianbergmann/phpunit/issues/3123
        'PHPUnit_Framework_MockObject_MockObject' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\MockObject',
    ]]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertEqualsParameterToSpecificMethodsTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'setUpBeforeClass', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'setUp', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'assertPreConditions', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'assertPostConditions', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'tearDown', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'tearDownAfterClass', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'onNotSuccessfulTest', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType())])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\ReplaceAssertArraySubsetWithDmsPolyfillRector::class);
};
