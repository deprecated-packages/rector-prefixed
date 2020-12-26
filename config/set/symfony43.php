<?php

declare (strict_types=1);
namespace RectorPrefix20201226;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201226\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201226\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        'RectorPrefix20201226\\Symfony\\Component\\BrowserKit\\Client' => 'RectorPrefix20201226\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\ChainCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\NullCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\PdoCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\RedisCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        'RectorPrefix20201226\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => 'RectorPrefix20201226\\Symfony\\Component\\Cache\\Psr16Cache',
        'RectorPrefix20201226\\Psr\\SimpleCache\\CacheInterface' => 'RectorPrefix20201226\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        'RectorPrefix20201226\\Symfony\\Component\\EventDispatcher\\Event' => 'RectorPrefix20201226\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        'RectorPrefix20201226\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => 'RectorPrefix20201226\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix20201226\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => 'RectorPrefix20201226\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix20201226\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => 'RectorPrefix20201226\\Symfony\\Component\\Mime\\MimeTypes',
        'RectorPrefix20201226\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => 'RectorPrefix20201226\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        'RectorPrefix20201226\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => 'RectorPrefix20201226\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => 'RectorPrefix20201226\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        'RectorPrefix20201226\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => 'RectorPrefix20201226\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        'RectorPrefix20201226\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => 'RectorPrefix20201226\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix20201226\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['RectorPrefix20201226\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
