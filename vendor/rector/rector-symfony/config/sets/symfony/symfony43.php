<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\ValueObject\ArgumentAdder;
use Rector\Core\ValueObject\MethodName;
use Rector\DependencyInjection\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210321\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210321\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        'RectorPrefix20210321\\Symfony\\Component\\BrowserKit\\Client' => 'RectorPrefix20210321\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\ChainCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\NullCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\PdoCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\RedisCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        'RectorPrefix20210321\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => 'RectorPrefix20210321\\Symfony\\Component\\Cache\\Psr16Cache',
        'RectorPrefix20210321\\Psr\\SimpleCache\\CacheInterface' => 'RectorPrefix20210321\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        'RectorPrefix20210321\\Symfony\\Component\\EventDispatcher\\Event' => 'RectorPrefix20210321\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        'RectorPrefix20210321\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => 'RectorPrefix20210321\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix20210321\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => 'RectorPrefix20210321\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix20210321\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => 'RectorPrefix20210321\\Symfony\\Component\\Mime\\MimeTypes',
        'RectorPrefix20210321\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => 'RectorPrefix20210321\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        'RectorPrefix20210321\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => 'RectorPrefix20210321\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => 'RectorPrefix20210321\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        'RectorPrefix20210321\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => 'RectorPrefix20210321\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        'RectorPrefix20210321\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => 'RectorPrefix20210321\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Arguments\ValueObject\ArgumentAdder('RectorPrefix20210321\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\DependencyInjection\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\DependencyInjection\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['RectorPrefix20210321\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => \Rector\Core\ValueObject\MethodName::CONSTRUCT]]]);
};
