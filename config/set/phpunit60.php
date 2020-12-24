<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase', 'createMockBuilder', 'getMockBuilder')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHPUnit_Framework_MockObject_Stub' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Stub', 'PHPUnit_Framework_MockObject_Stub_Return' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Stub\\ReturnStub', 'PHPUnit_Framework_MockObject_Matcher_Parameters' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Matcher\\Parameters', 'PHPUnit_Framework_MockObject_Matcher_Invocation' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Matcher\\Invocation', 'PHPUnit_Framework_MockObject_MockObject' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object' => '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Invocation\\ObjectInvocation']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class)->call('configure', [[
        // ref. https://github.com/sebastianbergmann/phpunit/compare/5.7.9...6.0.0
        \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('PHPUnit_', ['PHPUnit_Framework_MockObject_MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object', 'PHPUnit_Framework_MockObject_Matcher_Invocation', 'PHPUnit_Framework_MockObject_Matcher_Parameters', 'PHPUnit_Framework_MockObject_Stub_Return', 'PHPUnit_Framework_MockObject_Stub'])]),
    ]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector::class);
};
