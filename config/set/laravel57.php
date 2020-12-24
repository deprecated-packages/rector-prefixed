<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector;
use _PhpScoper0a6b37af0871\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.7/upgrade
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Middleware\\Authenticate', 'authenticate', 0, 'request'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Illuminate\\Foundation\\Auth\\ResetsPasswords', 'sendResetResponse', 0, 'request', null, '_PhpScoper0a6b37af0871\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Illuminate\\Foundation\\Auth\\SendsPasswordResetEmails', 'sendResetLinkResponse', 0, 'request', null, '_PhpScoper0a6b37af0871\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Illuminate\\Database\\ConnectionInterface', 'select', 2, 'useReadPdo', \true), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Illuminate\\Database\\ConnectionInterface', 'selectOne', 2, 'useReadPdo', \true)])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoper0a6b37af0871\\Illuminate\\Foundation\\Application', 'register', 1, ['name' => 'options'])])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector::class);
};
