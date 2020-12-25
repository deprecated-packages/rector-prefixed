<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperf18a0c41e2d2\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperf18a0c41e2d2\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperf18a0c41e2d2\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperf18a0c41e2d2\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
