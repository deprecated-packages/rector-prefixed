<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScopere8e811afab72\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScopere8e811afab72\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScopere8e811afab72\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScopere8e811afab72\\Psr\\SimpleCache\\CacheInterface' => '_PhpScopere8e811afab72\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScopere8e811afab72\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScopere8e811afab72\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScopere8e811afab72\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScopere8e811afab72\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScopere8e811afab72\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
