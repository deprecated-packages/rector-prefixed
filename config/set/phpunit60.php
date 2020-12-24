<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'createMockBuilder', 'getMockBuilder')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHPUnit_Framework_MockObject_Stub' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Stub', 'PHPUnit_Framework_MockObject_Stub_Return' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Stub\\ReturnStub', 'PHPUnit_Framework_MockObject_Matcher_Parameters' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Matcher\\Parameters', 'PHPUnit_Framework_MockObject_Matcher_Invocation' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Matcher\\Invocation', 'PHPUnit_Framework_MockObject_MockObject' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object' => '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Invocation\\ObjectInvocation']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class)->call('configure', [[
        // ref. https://github.com/sebastianbergmann/phpunit/compare/5.7.9...6.0.0
        \_PhpScoperb75b35f52b74\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('PHPUnit_', ['PHPUnit_Framework_MockObject_MockObject', 'PHPUnit_Framework_MockObject_Invocation_Object', 'PHPUnit_Framework_MockObject_Matcher_Invocation', 'PHPUnit_Framework_MockObject_Matcher_Parameters', 'PHPUnit_Framework_MockObject_Stub_Return', 'PHPUnit_Framework_MockObject_Stub'])]),
    ]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector::class);
};
