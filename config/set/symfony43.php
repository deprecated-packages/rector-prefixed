<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

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
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper26e51eeacccf\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper26e51eeacccf\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\Rector\Symfony\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoper26e51eeacccf\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoper26e51eeacccf\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoper26e51eeacccf\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoper26e51eeacccf\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoper26e51eeacccf\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper26e51eeacccf\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoper26e51eeacccf\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
