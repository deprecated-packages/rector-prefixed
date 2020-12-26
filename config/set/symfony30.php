<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Rector\Symfony3\Rector\ClassMethod\FormTypeGetParentRector;
use Rector\Symfony3\Rector\ClassMethod\GetRequestRector;
use Rector\Symfony3\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use Rector\Symfony3\Rector\MethodCall\CascadeValidationFormBuilderRector;
use Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector;
use Rector\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use Rector\Symfony3\Rector\MethodCall\OptionNameRector;
use Rector\Symfony3\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
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
    $services->set(\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector::class);
    $services->set(\Rector\Symfony3\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \Rector\Renaming\ValueObject\RenameClassConstant('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', 'RectorPrefix2020DecSat\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        'RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => 'RectorPrefix2020DecSat\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        'RectorPrefix2020DecSat\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Debug\\ErrorHandler',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Debug\\ExceptionHandler',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => 'RectorPrefix2020DecSat\\Psr\\Log\\LoggerInterface',
        # event disptacher
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => 'RectorPrefix2020DecSat\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        'RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger' => 'RectorPrefix2020DecSat\\Psr\\Log\\LoggerInterface',
        # security
        'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        'RectorPrefix2020DecSat\\Symfony\\Component\\Translation\\Translator' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Constraints\\Optional',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Constraints\\Required',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\MetadataInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ClassBasedInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\ExecutionContextInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        'RectorPrefix2020DecSat\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => 'RectorPrefix2020DecSat\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
