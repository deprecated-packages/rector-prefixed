<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperfce0de0de1ce\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperfce0de0de1ce\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperfce0de0de1ce\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperfce0de0de1ce\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperfce0de0de1ce\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperfce0de0de1ce\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
