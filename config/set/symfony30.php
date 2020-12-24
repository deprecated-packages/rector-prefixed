<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\GetRequestRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\OptionNameRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # resources:
    # - https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md
    # php
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\GetRequestRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\OptionNameRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector::class);
    # forms
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector::class);
    # forms - collection
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', '_PhpScoperb75b35f52b74\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Debug\\ErrorHandler',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Debug\\ExceptionHandler',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => '_PhpScoperb75b35f52b74\\Psr\\Log\\LoggerInterface',
        # event disptacher
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => '_PhpScoperb75b35f52b74\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        '_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Monolog\\Logger' => '_PhpScoperb75b35f52b74\\Psr\\Log\\LoggerInterface',
        # security
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Translation\\Translator' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Constraints\\Optional',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Constraints\\Required',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\MetadataInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ClassBasedInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\ExecutionContextInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        '_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
