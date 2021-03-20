<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector;
use Rector\Symfony3\Rector\ClassMethod\GetRequestRector;
use Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector;
use Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use Rector\Symfony3\Rector\MethodCall\ChangeStringCollectionOptionToConstantRector;
use Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use Rector\Symfony3\Rector\MethodCall\OptionNameRector;
use Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # resources:
    # - https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md
    # php
    $services->set(\Rector\Symfony3\Rector\ClassMethod\GetRequestRector::class);
    $services->set(\Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\OptionNameRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector::class);
    # forms
    $services->set(\Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector::class);
    $services->set(\Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector::class);
    # forms - collection
    $services->set(\Rector\Symfony3\Rector\MethodCall\ChangeStringCollectionOptionToConstantRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \Rector\Renaming\ValueObject\RenameClassConstFetch('RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', 'RectorPrefix20210320\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        'RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => 'RectorPrefix20210320\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        'RectorPrefix20210320\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => 'RectorPrefix20210320\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => 'RectorPrefix20210320\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => 'RectorPrefix20210320\\Symfony\\Component\\Debug\\ErrorHandler',
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => 'RectorPrefix20210320\\Symfony\\Component\\Debug\\ExceptionHandler',
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => 'RectorPrefix20210320\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => 'RectorPrefix20210320\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => 'RectorPrefix20210320\\Psr\\Log\\LoggerInterface',
        # event disptacher
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => 'RectorPrefix20210320\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        'RectorPrefix20210320\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => 'RectorPrefix20210320\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        'RectorPrefix20210320\\Symfony\\Bridge\\Monolog\\Logger' => 'RectorPrefix20210320\\Psr\\Log\\LoggerInterface',
        # security
        'RectorPrefix20210320\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => 'RectorPrefix20210320\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        'RectorPrefix20210320\\Symfony\\Component\\Translation\\Translator' => 'RectorPrefix20210320\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        'RectorPrefix20210320\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Constraints\\Optional',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Constraints\\Required',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\MetadataInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\ClassBasedInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\ExecutionContextInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => 'RectorPrefix20210320\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        'RectorPrefix20210320\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => 'RectorPrefix20210320\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
