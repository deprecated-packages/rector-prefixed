<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Rector\Symfony\Rector\ClassMethod\FormTypeGetParentRector;
use Rector\Symfony\Rector\ClassMethod\GetRequestRector;
use Rector\Symfony\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector;
use Rector\Symfony\Rector\MethodCall\CascadeValidationFormBuilderRector;
use Rector\Symfony\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector;
use Rector\Symfony\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector;
use Rector\Symfony\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use Rector\Symfony\Rector\MethodCall\OptionNameRector;
use Rector\Symfony\Rector\MethodCall\ReadOnlyOptionToAttributeRector;
use Rector\Symfony\Rector\MethodCall\StringFormTypeToClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # resources:
    # - https://github.com/symfony/symfony/blob/3.4/UPGRADE-3.0.md
    # php
    $services->set(\Rector\Symfony\Rector\ClassMethod\GetRequestRector::class);
    $services->set(\Rector\Symfony\Rector\ClassMethod\FormTypeGetParentRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\OptionNameRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ReadOnlyOptionToAttributeRector::class);
    # forms
    $services->set(\Rector\Symfony\Rector\MethodCall\FormTypeInstanceToClassConstRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\StringFormTypeToClassRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\CascadeValidationFormBuilderRector::class);
    $services->set(\Rector\Symfony\Rector\ClassMethod\RemoveDefaultGetBlockPrefixRector::class);
    # forms - collection
    $services->set(\Rector\Symfony\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ChangeCollectionTypeOptionNameFromTypeToEntryTypeRector::class);
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', '_PhpScopera143bcca66cb\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        '_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => '_PhpScopera143bcca66cb\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Debug\\ErrorHandler',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Debug\\ExceptionHandler',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => '_PhpScopera143bcca66cb\\Psr\\Log\\LoggerInterface',
        # event disptacher
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => '_PhpScopera143bcca66cb\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => '_PhpScopera143bcca66cb\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        '_PhpScopera143bcca66cb\\Symfony\\Bridge\\Monolog\\Logger' => '_PhpScopera143bcca66cb\\Psr\\Log\\LoggerInterface',
        # security
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Translation\\Translator' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        '_PhpScopera143bcca66cb\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Constraints\\Optional',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Constraints\\Required',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\MetadataInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ClassBasedInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\ExecutionContextInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        '_PhpScopera143bcca66cb\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => '_PhpScopera143bcca66cb\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
