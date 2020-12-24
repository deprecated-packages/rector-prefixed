<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://symfony.com/blog/new-in-symfony-4-3-better-test-assertions
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\BrowserKit\\Response', 'getStatus', 'getStatusCode'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Http\\Firewall', 'handleRequest', 'callListeners')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\MakeDispatchFirstArgumentEventRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
        # Browser Kit
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\BrowserKit\\Client' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\BrowserKit\\AbstractBrowser',
        # Cache
        # https://github.com/symfony/symfony/pull/29236
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Traits\\ApcuTrait\\ApcuAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\SimpleCacheAdapter' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\Psr16Adapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\ArrayCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\ArrayAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\ChainCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\ChainAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\DoctrineCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\DoctrineAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\FilesystemCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\MemcachedCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\MemcachedAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\NullCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\NullAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\PdoCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\PdoAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\PhpArrayCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\PhpArrayAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\PhpFilesCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\PhpFilesAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\RedisCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\RedisAdapter',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\TraceableCache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Adapter\\TraceableAdapterCache',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Simple\\Psr6Cache' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Cache\\Psr16Cache',
        '_PhpScoperb75b35f52b74\\Psr\\SimpleCache\\CacheInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Contracts\\Cache\\CacheInterface',
        # EventDispatcher
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerArgumentsEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\ControllerEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\ResponseEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\RequestEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForControllerResultEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\ViewEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\PostResponseEvent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\Event\\TerminateEvent',
        # has lowest priority, have to be last
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\EventDispatcher\\Event' => '_PhpScoperb75b35f52b74\\Symfony\\Contracts\\EventDispatcher\\Event',
        # MimeType
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Mime\\MimeTypesInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Mime\\MimeTypes',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Mime\\FileBinaryMimeTypeGuesser',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Mime\\FileinfoMimeTypeGuesser',
        # HttpKernel
        # @todo unpack after YAML to PHP migration, Symfony\Component\HttpKernel\Client: Symfony\Component\HttpKernel\HttpKernelBrowser
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\EventListener\\TranslatorListener' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\EventListener\\LocaleAwareListener',
        # Security
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Encoder\\Argon2iPasswordEncoder' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Encoder\\BCryptPasswordEncoder' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder',
    ]]]);
    # https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.3.md#workflow
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\MarkingStore\\MarkingStoreInterface', 'setMarking', 2, 'context', [])])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => ['_PhpScoperb75b35f52b74\\Symfony\\Component\\EventDispatcher\\EventDispatcher' => '__construct']]]);
};
