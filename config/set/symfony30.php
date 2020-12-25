<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

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
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
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
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\FormEvents', 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\FormEvents', 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\FormEvents', 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFEVEN', 'ROUND_HALF_EVEN'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFUP', 'ROUND_HALF_UP'), new \Rector\Renaming\ValueObject\RenameClassConstant('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\DataTransformer', 'ROUND_HALFDOWN', 'ROUND_HALF_DOWN')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespaces', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefixes', 'addPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerNamespace', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'registerPrefix', 'addPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaces', 'getPrefixes'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getNamespaceFallbacks', 'getFallbackDirs'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader', 'getPrefixFallbacks', 'getFallbackDirs'),
        // form
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\AbstractType', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\AbstractType', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\FormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\FormTypeInterface', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ResolvedFormTypeInterface', 'getName', 'getBlockPrefix'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\AbstractTypeExtension', 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Form', 'bind', 'submit'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Form', 'isBound', 'isSubmitted'),
        // process
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Process\\Process', 'setStdin', 'setInput'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Process\\Process', 'getStdin', 'getInput'),
        // monolog
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Monolog\\Logger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Monolog\\Logger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Monolog\\Logger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Monolog\\Logger', 'warn', 'warning'),
        # http kernel
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface', 'warn', 'warning'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'emerg', 'emergency'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'crit', 'critical'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'err', 'error'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\NullLogger', 'warn', 'warning'),
        // property access
        new \Rector\Renaming\ValueObject\MethodCallRename('getPropertyAccessor', '_PhpScoper8b9c402c5f32\\Symfony\\Component\\PropertyAccess\\PropertyAccess', 'createPropertyAccessor'),
        // translator
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Translation\\Dumper\\FileDumper', 'format', 'formatCatalogue'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Translation\\Translator', 'getMessages', 'getCatalogue'),
        // validator
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ConstraintViolationInterface', 'getMessagePluralization', 'getPlural'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessageParameters', 'getParameters'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ConstraintViolation', 'getMessagePluralization', 'getPlural'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # class loader
        # partial with method rename
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\UniversalClassLoader\\UniversalClassLoader' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\ClassLoader\\ClassLoader',
        # console
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\Helper\\ProgressHelper' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\Helper\\ProgressBar',
        # form
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Util\\VirtualFormAwareIterator' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Util\\InheritDataAwareIterator',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Tests\\Extension\\Core\\Type\\TypeTestCase' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Test\\TypeTestCase',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Tests\\FormIntegrationTestCase' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Test\\FormIntegrationTestCase',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Tests\\FormPerformanceTestCase' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Test\\FormPerformanceTestCase',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceListInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ChoiceListInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\View\\ChoiceView' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\View\\ChoiceView',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Csrf\\CsrfProvider\\CsrfProviderInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Security\\Csrf\\CsrfTokenManagerInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ChoiceList' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\LazyChoiceList' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\LazyChoiceList',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\ObjectChoiceList' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\Extension\\Core\\ChoiceList\\SimpleChoiceList' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ArrayKeyChoiceList' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\ChoiceList\\ArrayChoiceList',
        # http kernel
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Debug\\ErrorHandler',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Debug\\ExceptionHandler' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Debug\\ExceptionHandler',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Exception\\FatalErrorException' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Debug\\Exception\\FatalErrorException',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Exception\\FlattenException' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Debug\\Exception\\FlattenException',
        # partial with method rename
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\LoggerInterface' => '_PhpScoper8b9c402c5f32\\Psr\\Log\\LoggerInterface',
        # event disptacher
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\DependencyInjection\\RegisterListenersPass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\EventDispatcher\\DependencyInjection\\RegisterListenersPass',
        # partial with methor rename
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\Log\\NullLogger' => '_PhpScoper8b9c402c5f32\\Psr\\Log\\LoggerInterface',
        # monolog
        # partial with method rename
        '_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Monolog\\Logger' => '_PhpScoper8b9c402c5f32\\Psr\\Log\\LoggerInterface',
        # security
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\AbstractVoter' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Security\\Core\\Authorization\\Voter\\Voter',
        # translator
        # partial with class rename
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Translation\\Translator' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Translation\\TranslatorBagInterface',
        # twig
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\TwigBundle\\TwigDefaultEscapingStrategy' => 'Twig_FileExtensionEscapingStrategy',
        # validator
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Constraints\\Collection\\Optional' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Constraints\\Optional',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Constraints\\Collection\\Required' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Constraints\\Required',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\MetadataInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\MetadataInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\PropertyMetadataInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\PropertyMetadataInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\PropertyMetadataContainerInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ClassBasedInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\ElementMetadata' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\GenericMetadata',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\ExecutionContextInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Context\\ExecutionContextInterface',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\Factory\\LazyLoadingMetadataFactory',
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\MetadataFactoryInterface' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Mapping\\Factory\\MetadataFactoryInterface',
        # swift mailer
        '_PhpScoper8b9c402c5f32\\Symfony\\Bridge\\Swiftmailer\\DataCollector\\MessageDataCollector' => '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
    ]]]);
};
