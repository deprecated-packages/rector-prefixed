<?php

declare (strict_types=1);
namespace RectorPrefix20210120;

use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector;
use Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector;
use Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector;
use RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md
return static function (\RectorPrefix20210120\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/symfony50-types.php');
    $services = $containerConfigurator->services();
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#form
    $services->set(\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
    $services->set(\Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#mime
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Mime\\Address', 'fromString', 'create')])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyaccess
    $services->set(\Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyinfo
    $services->set(\Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#security
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstant('Symfony\\Component\\Security\\Http\\Firewall\\AccessListener', 'PUBLIC_ACCESS', 'Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AuthenticatedVoter::PUBLIC_ACCESS')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'getProviderKey', 'getFirewallName')])]]);
};
