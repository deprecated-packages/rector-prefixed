<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoper2a4e7ab1ecbc\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
