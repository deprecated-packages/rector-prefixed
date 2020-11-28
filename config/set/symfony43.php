<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

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
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperabd03f0baf05\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperabd03f0baf05\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperabd03f0baf05\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperabd03f0baf05\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperabd03f0baf05\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperabd03f0baf05\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperabd03f0baf05\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperabd03f0baf05\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperabd03f0baf05\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
