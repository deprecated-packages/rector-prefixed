<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperbf340cb0be9d\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperbf340cb0be9d\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperbf340cb0be9d\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbf340cb0be9d\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
