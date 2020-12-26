<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        'RectorPrefix2020DecSat\\Symfony\\Component\\BrowserKit\\Client' => 'RectorPrefix2020DecSat\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\ChainCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\NullCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\PdoCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\RedisCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Cache\\Psr16Cache',
        'RectorPrefix2020DecSat\\Psr\\SimpleCache\\CacheInterface' => 'RectorPrefix2020DecSat\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        'RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\Event' => 'RectorPrefix2020DecSat\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Mime\\MimeTypesInterface',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Mime\\MimeTypes',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix2020DecSat\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
