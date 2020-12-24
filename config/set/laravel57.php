<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector;
use _PhpScoperb75b35f52b74\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.7/upgrade
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Auth\\Middleware\\Authenticate', 'authenticate', 0, 'request'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Foundation\\Auth\\ResetsPasswords', 'sendResetResponse', 0, 'request', null, '_PhpScoperb75b35f52b74\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Foundation\\Auth\\SendsPasswordResetEmails', 'sendResetLinkResponse', 0, 'request', null, '_PhpScoperb75b35f52b74\\Illuminate\\Http\\Illuminate\\Http'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\ConnectionInterface', 'select', 2, 'useReadPdo', \true), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\ConnectionInterface', 'selectOne', 2, 'useReadPdo', \true)])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoperb75b35f52b74\\Illuminate\\Foundation\\Application', 'register', 1, ['name' => 'options'])])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_\AddGuardToLoginEventRector::class);
};
