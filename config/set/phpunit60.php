<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'createMockBuilder', 'getMockBuilder')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHPUnit_Framework_MockObject_Stub' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\Stub', 'PHPUnit_Framework_MockObject_Stub_Return' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\Stub\\ReturnStub', 'PHPUnit_Framework_MockObject_Matcher_Parameters' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\Matcher\\Parameters', 'PHPUnit_Framework_MockObject_Matcher_Invocation' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\Matcher\\Invocation', 'PHPUnit_Framework_MockObject_MockObject' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object' => '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\Invocation\\ObjectInvocation']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class)->call('configure', [[
        // ref. https://github.com/sebastianbergmann/phpunit/compare/5.7.9...6.0.0
        \_PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('PHPUnit_', ['PHPUnit_Framework_MockObject_MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object', 'PHPUnit_Framework_MockObject_Matcher_Invocation', 'PHPUnit_Framework_MockObject_Matcher_Parameters', 'PHPUnit_Framework_MockObject_Stub_Return', 'PHPUnit_Framework_MockObject_Stub'])]),
    ]]);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector::class);
};
