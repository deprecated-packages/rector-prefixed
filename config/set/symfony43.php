<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

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
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScopera143bcca66cb\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScopera143bcca66cb\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScopera143bcca66cb\\Psr\\SimpleCache\\CacheInterface' => '_PhpScopera143bcca66cb\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScopera143bcca66cb\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScopera143bcca66cb\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScopera143bcca66cb\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScopera143bcca66cb\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScopera143bcca66cb\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScopera143bcca66cb\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
