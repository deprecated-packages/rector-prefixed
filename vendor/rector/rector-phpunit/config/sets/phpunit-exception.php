<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector;
use Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # handles 2nd and 3rd argument of setExpectedException
    $services->set(\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector::class);
    $services->set(\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('PHPUnit\\Framework\\TestClass', 'setExpectedException', 'expectedException'), new \Rector\Renaming\ValueObject\MethodCallRename('PHPUnit\\Framework\\TestClass', 'setExpectedExceptionRegExp', 'expectedException')])]]);
};
