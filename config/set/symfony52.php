<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScopere8e811afab72\Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector;
use _PhpScopere8e811afab72\Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector;
use _PhpScopere8e811afab72\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use _PhpScopere8e811afab72\Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/symfony50-types.php');
    $services = $containerConfigurator->services();
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#form
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#mime
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\Address', 'fromString', 'create')])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyaccess
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyinfo
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#security
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Http\\Firewall\\AccessListener', 'PUBLIC_ACCESS', 'Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AuthenticatedVoter::PUBLIC_ACCESS')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'setProviderKey', 'setFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'getProviderKey', 'getFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'setProviderKey', 'setFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'getProviderKey', 'getFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'setProviderKey', 'setFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'getProviderKey', 'getFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'setProviderKey', 'setFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'getProviderKey', 'getFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'setProviderKey', 'setFirewallName'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'getProviderKey', 'getFirewallName')])]]);
};
