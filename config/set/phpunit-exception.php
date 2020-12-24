<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # handles 2nd and 3rd argument of setExpectedException
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestClass', 'setExpectedException', 'expectedException'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestClass', 'setExpectedExceptionRegExp', 'expectedException')])]]);
};
