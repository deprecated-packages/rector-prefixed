<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperbd5d0c5f7638\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperbd5d0c5f7638\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperbd5d0c5f7638\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperbd5d0c5f7638\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
