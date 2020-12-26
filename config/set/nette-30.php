<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector;
use Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use Rector\Nette\Rector\Class_\MoveFinalGetUserToCheckRequirementsClassMethodRector;
use Rector\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector;
use Rector\Nette\Rector\MethodCall\AddNextrasDatePickerToDateControlRector;
use Rector\Nette\Rector\MethodCall\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector;
use Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector;
use Rector\Nette\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector;
use Rector\Nette\Rector\MethodCall\RequestGetCookieDefaultArgumentToCoalesceRector;
use Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use Rector\Transform\ValueObject\StaticCallToMethodCall;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/nette-30-dependency-injection.php');
    $containerConfigurator->import(__DIR__ . '/nette-30-return-types.php');
    $containerConfigurator->import(__DIR__ . '/nette-30-param-types.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\MethodCall\AddNextrasDatePickerToDateControlRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector::class);
    $services->set(\Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector::class);
    // Control class has remove __construct(), e.g. https://github.com/Pixidos/GPWebPay/pull/16/files#diff-fdc8251950f85c5467c63c249df05786
    $services->set(\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    // https://github.com/nette/utils/commit/d0041ba59f5d8bf1f5b3795fd76d43fb13ea2e15
    $services->set(\Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector::class);
    $services->set(\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StaticCallToMethodCall('RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'hash', 'RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'hash'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'verify', 'RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'verify'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'needsRehash', 'RectorPrefix2020DecSat\\Nette\\Security\\Passwords', 'needsRehash')])]]);
    // https://github.com/contributte/event-dispatcher-extra/tree/v0.4.3 and higher
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent', 'NAME', 'class'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent', 'NAME', 'class'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent', 'NAME', 'class')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # nextras/forms was split into 2 packages
        'RectorPrefix2020DecSat\\Nextras\\FormComponents\\Controls\\DatePicker' => 'RectorPrefix2020DecSat\\Nextras\\FormComponents\\Controls\\DateControl',
        # @see https://github.com/nette/di/commit/a0d361192f8ac35f1d9f82aab7eb351e4be395ea
        'RectorPrefix2020DecSat\\Nette\\DI\\ServiceDefinition' => 'RectorPrefix2020DecSat\\Nette\\DI\\Definitions\\ServiceDefinition',
        'RectorPrefix2020DecSat\\Nette\\DI\\Statement' => 'RectorPrefix2020DecSat\\Nette\\DI\\Definitions\\Statement',
        'RectorPrefix2020DecSat\\WebChemistry\\Forms\\Controls\\Multiplier' => 'RectorPrefix2020DecSat\\Contributte\\FormMultiplier\\Multiplier',
    ]]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // json 2nd argument is now `int` typed
        new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Nette\\Utils\\Json', 'decode', 1, \true, 'Nette\\Utils\\Json::FORCE_ARRAY'),
        // @see https://github.com/nette/forms/commit/574b97f9d5e7a902a224e57d7d584e7afc9fefec
        new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Nette\\Forms\\Form', 'decode', 0, \true, 'array'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://github.com/nette/forms/commit/b99385aa9d24d729a18f6397a414ea88eab6895a
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\BaseControl', 'setType', 'setHtmlType'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\BaseControl', 'setAttribute', 'setHtmlAttribute'),
        new \Rector\Renaming\ValueObject\MethodCallRename(
            'RectorPrefix2020DecSat\\Nette\\DI\\Definitions\\ServiceDefinition',
            # see https://github.com/nette/di/commit/1705a5db431423fc610a6f339f88dead1b5dc4fb
            'setClass',
            'setType'
        ),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Nette\\DI\\Definitions\\ServiceDefinition', 'getClass', 'getType'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Nette\\DI\\Definitions\\Definition', 'isAutowired', 'getAutowired'),
    ])]]);
    $services->set(\Rector\Nette\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector::class);
    $services->set(\Rector\Nette\Rector\MethodCall\RequestGetCookieDefaultArgumentToCoalesceRector::class);
    $services->set(\Rector\Nette\Rector\ClassMethod\RemoveParentAndNameFromComponentConstructorRector::class);
    $services->set(\Rector\Nette\Rector\Class_\MoveFinalGetUserToCheckRequirementsClassMethodRector::class);
    $services->set(\Rector\Nette\Rector\MethodCall\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector::class);
};
