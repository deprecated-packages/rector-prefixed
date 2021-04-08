<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

# https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.1.md
use PHPStan\Type\ObjectType;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\String_\RenameStringRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Symfony\Rector\Class_\LogoutHandlerToLogoutEventSubscriberRector;
use Rector\Symfony\Rector\Class_\LogoutSuccessHandlerToLogoutEventSubscriberRector;
use Rector\Symfony\Rector\ClassMethod\RouteCollectionBuilderToRoutingConfiguratorRector;
use Rector\Transform\Rector\New_\NewArgToMethodCallRector;
use Rector\Transform\Rector\StaticCall\StaticCallToNewRector;
use Rector\Transform\ValueObject\NewArgToMethodCall;
use Rector\Transform\ValueObject\StaticCallToNew;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    // see https://github.com/symfony/symfony/pull/36243
    $services->set(\Rector\Symfony\Rector\Class_\LogoutHandlerToLogoutEventSubscriberRector::class);
    $services->set(\Rector\Symfony\Rector\Class_\LogoutSuccessHandlerToLogoutEventSubscriberRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        'Symfony\\Component\\EventDispatcher\\LegacyEventDispatcherProxy' => 'Symfony\\Component\\EventDispatcher\\EventDispatcherInterface',
        'Symfony\\Component\\Form\\Extension\\Validator\\Util\\ServerParams' => 'Symfony\\Component\\Form\\Util\\ServerParams',
        // see https://github.com/symfony/symfony/pull/35092
        'Symfony\\Component\\Inflector' => 'Symfony\\Component\\String\\Inflector\\InflectorInterface',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Config\\Definition\\BaseNode', 'getDeprecationMessage', 'getDeprecation'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\DependencyInjection\\Definition', 'getDeprecationMessage', 'getDeprecation'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\DependencyInjection\\Alias', 'getDeprecationMessage', 'getDeprecation')])]]);
    $services->set(\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['Symfony\\Component\\DependencyInjection\\Loader\\Configuraton\\inline' => 'Symfony\\Component\\DependencyInjection\\Loader\\Configuraton\\inline_service', 'Symfony\\Component\\DependencyInjection\\Loader\\Configuraton\\ref' => 'Symfony\\Component\\DependencyInjection\\Loader\\Configuraton\\service']]]);
    // https://github.com/symfony/symfony/pull/35308
    $services->set(\Rector\Transform\Rector\New_\NewArgToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\New_\NewArgToMethodCallRector::NEW_ARGS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\NewArgToMethodCall('Symfony\\Component\\Dotenv\\Dotenv', \true, 'usePutenv')])]]);
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_FLOOR', 'NumberFormatter', 'ROUND_FLOOR'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_DOWN', 'NumberFormatter', 'ROUND_DOWN'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_HALF_DOWN', 'NumberFormatter', 'ROUND_HALFDOWN'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_HALF_EVEN', 'NumberFormatter', 'ROUND_HALFEVEN'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_HALFUP', 'NumberFormatter', 'ROUND_HALFUP'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_UP', 'NumberFormatter', 'ROUND_UP'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Symfony\\Component\\Form\\Extension\\Core\\DataTransformer\\NumberToLocalizedStringTransformer', 'ROUND_CEILING', 'NumberFormatter', 'ROUND_CEILING')])]]);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[
        // see https://github.com/symfony/symfony/pull/36943
        \Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Symfony\\Bundle\\FrameworkBundle\\Kernel\\MicroKernelTrait', 'configureRoutes', 0, new \PHPStan\Type\ObjectType('Symfony\\Component\\Routing\\Loader\\Configurator\\RoutingConfigurator'))]),
    ]]);
    $services->set(\Rector\Transform\Rector\StaticCall\StaticCallToNewRector::class)->call('configure', [[\Rector\Transform\Rector\StaticCall\StaticCallToNewRector::STATIC_CALLS_TO_NEWS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StaticCallToNew('Symfony\\Component\\HttpFoundation\\Response', 'create'), new \Rector\Transform\ValueObject\StaticCallToNew('Symfony\\Component\\HttpFoundation\\JsonResponse', 'create'), new \Rector\Transform\ValueObject\StaticCallToNew('Symfony\\Component\\HttpFoundation\\RedirectResponse', 'create'), new \Rector\Transform\ValueObject\StaticCallToNew('Symfony\\Component\\HttpFoundation\\StreamedResponse', 'create')])]]);
    $services->set(\Rector\Renaming\Rector\String_\RenameStringRector::class)->call('configure', [[
        // @see https://github.com/symfony/symfony/pull/35858
        \Rector\Renaming\Rector\String_\RenameStringRector::STRING_CHANGES => ['ROLE_PREVIOUS_ADMIN' => 'IS_IMPERSONATOR'],
    ]]);
    $services->set(\Rector\Symfony\Rector\ClassMethod\RouteCollectionBuilderToRoutingConfiguratorRector::class);
};
