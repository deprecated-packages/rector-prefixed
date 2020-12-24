<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\GetRequestRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\OptionNameRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # resources:
    # - https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md
    # php
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\GetRequestRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\OptionNameRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector::class);
    # forms
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector::class);
    # forms - collection
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Debug\\ErrorHandler',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Debug\\ExceptionHandler',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => '_PhpScoper2a4e7ab1ecbc\\Psr\\Log\\LoggerInterface',
        # event disptacher
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => '_PhpScoper2a4e7ab1ecbc\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Monolog\\Logger' => '_PhpScoper2a4e7ab1ecbc\\Psr\\Log\\LoggerInterface',
        # security
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Translation\\Translator' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Constraints\\Optional',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Constraints\\Required',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\MetadataInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ClassBasedInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\ExecutionContextInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
