<?php

declare (strict_types=1);
namespace RectorPrefix20210220;

use PHPStan\Type\ObjectType;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\Symfony5\Rector\MethodCall\DefinitionAliasSetPrivateToSetPublicRector;
use Rector\Symfony5\Rector\MethodCall\FormBuilderSetDataMapperRector;
use Rector\Symfony5\Rector\MethodCall\ReflectionExtractorEnableMagicCallExtractorRector;
use Rector\Symfony5\Rector\MethodCall\ValidatorBuilderEnableAnnotationMappingRector;
use Rector\Symfony5\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector;
use Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use Rector\Symfony5\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use RectorPrefix20210220\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md
return static function (\RectorPrefix20210220\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
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
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Security\\Http\\Firewall\\AccessListener', 'PUBLIC_ACCESS', 'Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AuthenticatedVoter', 'PUBLIC_ACCESS')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\PreAuthenticatedToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\SwitchUserToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken', 'getProviderKey', 'getFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'setProviderKey', 'setFirewallName'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Http\\Authentication\\DefaultAuthenticationSuccessHandler', 'getProviderKey', 'getFirewallName')])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#dependencyinjection
    $services->set(\Rector\Symfony5\Rector\MethodCall\DefinitionAliasSetPrivateToSetPublicRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#form
    $services->set(\Rector\Symfony5\Rector\MethodCall\FormBuilderSetDataMapperRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#validator
    $services->set(\Rector\Symfony5\Rector\MethodCall\ValidatorBuilderEnableAnnotationMappingRector::class);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#notifier
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\NotifierInterface', 'send', 1, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\RecipientInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Notifier', 'getChannels', 1, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\RecipientInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Channel\\ChannelInterface', 'notify', 1, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\RecipientInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Channel\\ChannelInterface', 'supports', 1, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\RecipientInterface'))])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#notifier
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Notification\\ChatNotificationInterface', 'asChatMessage', 0, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\RecipientInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Notification\\EmailNotificationInterface', 'asEmailMessage', 0, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\EmailRecipientInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Component\\Notifier\\Notification\\SmsNotificationInterface', 'asSmsMessage', 0, new \PHPStan\Type\ObjectType('Symfony\\Component\\Notifier\\Recipient\\SmsRecipientInterface'))])]]);
    # https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#security
    $services->set(\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameProperty('Symfony\\Component\\Security\\Http\\RememberMe\\AbstractRememberMeServices', 'providerKey', 'firewallName')])]]);
};
