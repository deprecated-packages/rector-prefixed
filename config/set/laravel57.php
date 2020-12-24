<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector;
use _PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.7/upgrade
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Auth\\Middleware\\Authenticate', 'authenticate', 0, 'request'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Foundation\\Auth\\ResetsPasswords', 'sendResetResponse', 0, 'request', null, '_PhpScopere8e811afab72\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Foundation\\Auth\\SendsPasswordResetEmails', 'sendResetLinkResponse', 0, 'request', null, '_PhpScopere8e811afab72\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\ConnectionInterface', 'select', 2, 'useReadPdo', \true), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\ConnectionInterface', 'selectOne', 2, 'useReadPdo', \true)])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover('_PhpScopere8e811afab72\\Illuminate\\Foundation\\Application', 'register', 1, ['name' => 'options'])])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector::class);
};
