<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoper0a6b37af0871\Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector;
use _PhpScoper0a6b37af0871\Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector;
use _PhpScoper0a6b37af0871\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use _PhpScoper0a6b37af0871\Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/symfony50-types.php');
    $services = $containerConfigurator->services();
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#form
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#mime
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\Address', 'fromString', 'create')])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyaccess
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyinfo
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#security
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Http\\Firewall\\AccessListener', 'PUBLIC_ACCESS', 'Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AuthenticatedVoter::PUBLIC_ACCESS')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'setProviderKey', 'setFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'getProviderKey', 'getFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'setProviderKey', 'setFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'getProviderKey', 'getFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'setProviderKey', 'setFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'getProviderKey', 'getFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'setProviderKey', 'setFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'getProviderKey', 'getFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'setProviderKey', 'setFirewallName'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'getProviderKey', 'getFirewallName')])]]);
};
