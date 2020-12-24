<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\GetRequestRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\OptionNameRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # resources:
    # - https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md
    # php
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\GetRequestRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\OptionNameRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector::class);
    # forms
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector::class);
    # forms - collection
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', '_PhpScopere8e811afab72\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        '_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => '_PhpScopere8e811afab72\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => '_PhpScopere8e811afab72\\Symfony\\Component\\Debug\\ErrorHandler',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => '_PhpScopere8e811afab72\\Symfony\\Component\\Debug\\ExceptionHandler',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => '_PhpScopere8e811afab72\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => '_PhpScopere8e811afab72\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => '_PhpScopere8e811afab72\\Psr\\Log\\LoggerInterface',
        # event disptacher
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => '_PhpScopere8e811afab72\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => '_PhpScopere8e811afab72\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        '_PhpScopere8e811afab72\\Symfony\\Bridge\\Monolog\\Logger' => '_PhpScopere8e811afab72\\Psr\\Log\\LoggerInterface',
        # security
        '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        '_PhpScopere8e811afab72\\Symfony\\Component\\Translation\\Translator' => '_PhpScopere8e811afab72\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Optional',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Required',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\MetadataInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ClassBasedInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\ExecutionContextInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        '_PhpScopere8e811afab72\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => '_PhpScopere8e811afab72\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
