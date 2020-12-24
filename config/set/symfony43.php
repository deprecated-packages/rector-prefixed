<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoper0a6b37af0871\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoper0a6b37af0871\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoper0a6b37af0871\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoper0a6b37af0871\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
