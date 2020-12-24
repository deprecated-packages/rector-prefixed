<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Class_\MoveFinalGetUserToCheckRequirementsClassMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\AddNextrasDatePickerToDateControlRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\RequestGetCookieDefaultArgumentToCoalesceRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/nette-30-dependency-injection.php');
    $containerConfigurator->import(__DIR__ . '/nette-30-return-types.php');
    $containerConfigurator->import(__DIR__ . '/nette-30-param-types.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\AddNextrasDatePickerToDateControlRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector::class);
    // Control class has remove __construct(), e.g. https://github.com/Pixidos/GPWebPay/pull/16/files#diff-fdc8251950f85c5467c63c249df05786
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    // https://github.com/nette/utils/commit/d0041ba59f5d8bf1f5b3795fd76d43fb13ea2e15
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'hash', '_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'hash'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'verify', '_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'verify'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'needsRehash', '_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\Passwords', 'needsRehash')])]]);
    // https://github.com/contributte/event-dispatcher-extra/tree/v0.4.3 and higher
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent', 'NAME', 'class'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent', 'NAME', 'class'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent', 'NAME', 'class')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # nextras/forms was split into 2 packages
        '_PhpScoper2a4e7ab1ecbc\\Nextras\\FormComponents\\Controls\\DatePicker' => '_PhpScoper2a4e7ab1ecbc\\Nextras\\FormComponents\\Controls\\DateControl',
        # @see https://github.com/nette/di/commit/a0d361192f8ac35f1d9f82aab7eb351e4be395ea
        '_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\ServiceDefinition' => '_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Definitions\\ServiceDefinition',
        '_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Statement' => '_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Definitions\\Statement',
        '_PhpScoper2a4e7ab1ecbc\\WebChemistry\\Forms\\Controls\\Multiplier' => '_PhpScoper2a4e7ab1ecbc\\Contributte\\FormMultiplier\\Multiplier',
    ]]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // json 2nd argument is now `int` typed
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Json', 'decode', 1, \true, 'Nette\\Utils\\Json::FORCE_ARRAY'),
        // @see https://github.com/nette/forms/commit/574b97f9d5e7a902a224e57d7d584e7afc9fefec
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Form', 'decode', 0, \true, 'array'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://github.com/nette/forms/commit/b99385aa9d24d729a18f6397a414ea88eab6895a
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\BaseControl', 'setType', 'setHtmlType'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\BaseControl', 'setAttribute', 'setHtmlAttribute'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename(
            '_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Definitions\\ServiceDefinition',
            # see https://github.com/nette/di/commit/1705a5db431423fc610a6f339f88dead1b5dc4fb
            'setClass',
            'setType'
        ),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Definitions\\ServiceDefinition', 'getClass', 'getType'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Nette\\DI\\Definitions\\Definition', 'isAutowired', 'getAutowired'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\RequestGetCookieDefaultArgumentToCoalesceRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Class_\MoveFinalGetUserToCheckRequirementsClassMethodRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\MethodCall\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector::class);
};
