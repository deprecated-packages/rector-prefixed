<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoper5b8c9e9ebd21\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoper5b8c9e9ebd21\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
