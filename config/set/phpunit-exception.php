<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # handles 2nd and 3rd argument of setExpectedException
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestClass', 'setExpectedException', 'expectedException'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestClass', 'setExpectedExceptionRegExp', 'expectedException')])]]);
};
