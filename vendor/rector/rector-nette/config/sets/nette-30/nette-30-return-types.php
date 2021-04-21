<?php

declare(strict_types=1);

use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    # scalar type hints, see https://github.com/nette/security/commit/84024f612fb3f55f5d6e3e3e28eef1ad0388fa56
    $arrayType = new ArrayType(new MixedType(), new MixedType());

    $services->set(AddReturnTypeDeclarationRector::class)
        ->call('configure', [[
            AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => ValueObjectInliner::inline([
                new AddReturnTypeDeclaration('Nette\Mail\Mailer', 'send', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Forms\Rendering\DefaultFormRenderer',
                    'renderControl',
                    new ObjectType('Nette\Utils\Html')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Forms\Container',
                    'addContainer',
                    new ObjectType('Nette\Forms\Container')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Forms\Container',
                    'addSelect',
                    new ObjectType('Nette\Forms\Controls\SelectBox')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Forms\Container',
                    'addMultiSelect',
                    new ObjectType('Nette\Forms\Controls\MultiSelectBox')
                ),
                new AddReturnTypeDeclaration('Nette\Forms\IFormRenderer', 'render', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Forms\Controls\TextBase',
                    'getControl',
                    new ObjectType('Nette\Utils\Html')
                ),
                new AddReturnTypeDeclaration(
                    'RadekDostal\NetteComponents\DateTimePicker\DateTimePicker',
                    'register',
                    new VoidType()
                ),
                new AddReturnTypeDeclaration('Nette\Caching\Cache', 'generateKey', new StringType()),
                new AddReturnTypeDeclaration('Nette\Localization\ITranslator', 'translate', new StringType()),
                new AddReturnTypeDeclaration('Nette\Security\IResource', 'getResourceId', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Security\IAuthenticator',
                    'authenticate',
                    new ObjectType('Nette\Security\IIdentity')
                ),
                new AddReturnTypeDeclaration('Nette\Security\IAuthorizator', 'isAllowed', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Security\Identity', 'getData', $arrayType),
                new AddReturnTypeDeclaration('Nette\Security\IIdentity', 'getRoles', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Security\User',
                    'getStorage',
                    new ObjectType('Nette\Security\IUserStorage')
                ),
                new AddReturnTypeDeclaration('Nette\Security\User', 'login', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Security\User', 'logout', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Security\User', 'isLoggedIn', new BooleanType()),

                new AddReturnTypeDeclaration(
                    'Nette\Security\User',
                    'getIdentity',
                    new UnionType([new ObjectType('Nette\Security\IIdentity'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Security\User',
                    'getAuthenticator',
                    new UnionType([new ObjectType('Nette\Security\IAuthenticator'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Security\User',
                    'getAuthorizator',
                    new UnionType([new ObjectType('Nette\Security\IAuthorizator'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Security\User', 'getLogoutReason',
                    new UnionType([new IntegerType(), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Security\User', 'getRoles', $arrayType),
                new AddReturnTypeDeclaration('Nette\Security\User', 'isInRole', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Security\User', 'isAllowed', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Security\IUserStorage', 'isAuthenticated', new BooleanType()),
                new AddReturnTypeDeclaration(
                    'Nette\Security\IUserStorage',
                    'getIdentity',
                    new UnionType([new ObjectType('Nette\Security\IIdentity'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Security\IUserStorage',
                    'getLogoutReason',
                    new UnionType([new IntegerType(), new NullType()])),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Component',
                    'lookup',
                    new ObjectType('Nette\ComponentModel\IComponent')
                ),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Component', 'lookupPath', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Component', 'monitor', new VoidType()),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Component', 'unmonitor', new VoidType()),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Component', 'attached', new VoidType()),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Component', 'detached', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Component',
                    'getName',
                    new UnionType([new StringType(), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\IComponent',
                    'getName',
                    new UnionType([new StringType(), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\IComponent',
                    'getParent',
                    new UnionType([new ObjectType('Nette\ComponentModel\IContainer'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Container', 'removeComponent', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Container',
                    'getComponent',
                    new UnionType([new ObjectType('Nette\ComponentModel\IComponent'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Container',
                    'createComponent',
                    new UnionType([new ObjectType('Nette\ComponentModel\IComponent'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\ComponentModel\Container', 'getComponents',
                    new ObjectType('Iterator')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Container',
                    'validateChildComponent',
                    new VoidType()
                ),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\Container',
                    '_isCloning',
                    new UnionType([new ObjectType('Nette\ComponentModel\IComponent'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\ComponentModel\IContainer', 'removeComponent', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\ComponentModel\IContainer',
                    'getComponent',
                    new UnionType([new ObjectType('Nette\ComponentModel\IContainer'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\ComponentModel\IContainer', 'getComponents', new ObjectType(
                    'Iterator'
                )),
                new AddReturnTypeDeclaration('Nette\Application\Application', 'run', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Application',
                    'createInitialRequest',
                    new ObjectType('Nette\Application\Request')
                ),
                new AddReturnTypeDeclaration('Nette\Application\Application', 'processRequest', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\Application', 'processException', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\Application', 'getRequests', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Application',
                    'getPresenter',
                    new UnionType([new ObjectType('Nette\Application\IPresenter'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Application',
                    'getRouter',
                    new UnionType([new ObjectType('Nette\Application\IRouter'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Application',
                    'getPresenterFactory',
                    new UnionType([new ObjectType('Nette\Application\IPresenterFactory'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\Helpers', 'splitName', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Application\IPresenter',
                    'run',
                    new ObjectType('Nette\Application\IResponse')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\IPresenterFactory',
                    'getPresenterClass',
                    new StringType()
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\IPresenterFactory',
                    'createPresenter',
                    new ObjectType('Nette\Application\IPresenter')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\PresenterFactory',
                    'formatPresenterClass',
                    new StringType()
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\PresenterFactory',
                    'unformatPresenterClass',
                    new UnionType([new StringType(), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\IResponse', 'send', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\Responses\FileResponse', 'getFile', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\Responses\FileResponse', 'getName', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Responses\FileResponse',
                    'getContentType',
                    new StringType()
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Responses\ForwardResponse',
                    'getRequest',
                    new ObjectType('Nette\Application\Request')
                ),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'getPresenterName', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'getParameters', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'getFiles', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'getMethod', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'isMethod', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\Request', 'hasFlag', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\RedirectResponse', 'getUrl', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\RedirectResponse', 'getCode', new IntegerType()),
                new AddReturnTypeDeclaration('Nette\Application\JsonResponse', 'getContentType', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\IRouter',
                    'match',
                    new UnionType([new ObjectType('Nette\Application\Request'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\IRouter', 'constructUrl', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\Routers\Route', 'getMask', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\Routers\Route', 'getDefaults', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\Routers\Route', 'getFlags', new IntegerType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Routers\Route',
                    'getTargetPresenters',
                    new UnionType([$arrayType, new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\Routers\RouteList', 'warmupCache', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\Routers\RouteList', 'offsetSet', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\Routers\RouteList', 'getModule', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\Routers\CliRouter', 'getDefaults', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Component',
                    'getPresenter',
                    new UnionType([new ObjectType('Nette\Application\UI\Presenter'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'getUniqueId', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'tryCall', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'checkRequirements', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Component',
                    'getReflection',
                    new ObjectType('Nette\Application\UI\ComponentReflection')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'loadState', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'saveState', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'getParameters', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'getParameterId', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'getPersistentParams', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'signalReceived', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'formatSignalMethod', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'link', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Component',
                    'lazyLink',
                    new ObjectType('Nette\Application\UI\Link')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'isLinkCurrent', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'redirect', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'redirectPermanent', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'offsetSet', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Component',
                    'offsetGet',
                    new ObjectType('Nette\ComponentModel\IComponent')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'offsetExists', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Component', 'offsetUnset', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getRequest',
                    new ObjectType('Nette\Application\Request')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getPresenter',
                    new ObjectType('Nette\Application\UI\Presenter')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getUniqueId', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'checkRequirements', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'processSignal', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getSignal',
                    new UnionType([$arrayType, new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'isSignalReceiver', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getAction', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'changeAction', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getView', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'sendTemplate', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'findLayoutTemplateFile', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'formatLayoutTemplateFiles', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'formatTemplateFiles', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'formatActionMethod', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'formatRenderMethod', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'createTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getPayload',
                    new ObjectType('stdClass')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'isAjax', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'sendPayload', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'sendJson', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'sendResponse', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'terminate', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'forward', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'redirectUrl', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'error', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getLastCreatedRequest',
                    new UnionType([new ObjectType('Nette\Application\Request'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getLastCreatedRequestFlag',
                    new BooleanType()
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'canonicalize', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'lastModified', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'createRequest', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'argsToParams', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'handleInvalidLink', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'storeRequest', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'restoreRequest', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getPersistentComponents', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getGlobalState', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'saveGlobalState', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'initGlobalParameters', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'popGlobalParameters', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'getFlashKey', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Application\UI\Presenter', 'hasFlashSession', new BooleanType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getFlashSession',
                    new ObjectType('Nette\Http\SessionSection')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getContext',
                    new ObjectType('Nette\DI\Container')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getHttpRequest',
                    new ObjectType('Nette\Http\IRequest')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getHttpResponse',
                    new ObjectType('Nette\Http\IResponse')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getUser',
                    new ObjectType('Nette\Security\User')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Presenter',
                    'getTemplateFactory',
                    new ObjectType('Nette\Application\UI\ITemplateFactory')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Exception\BadRequestException',
                    'getHttpCode',
                    new IntegerType()
                ),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationDI\LatteExtension', 'addMacro', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationDI\PresenterFactoryCallback',
                    '__invoke',
                    new ObjectType('Nette\Application\IPresenter')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationLatte\ILatteFactory',
                    'create',
                    new ObjectType('Latte\Engine')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationLatte\Template',
                    'getLatte',
                    new ObjectType('Latte\Engine')
                ),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', 'render', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', '__toString', new StringType()),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', 'getFile', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', 'getParameters', $arrayType),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', '__set', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\Template', '__unset', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationLatte\TemplateFactory',
                    'createTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\UIMacros', 'initialize', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationTracy\RoutingPanel',
                    'initializePanel',
                    new VoidType()
                ),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationTracy\RoutingPanel', 'getTab', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Bridges\ApplicationTracy\RoutingPanel',
                    'getPanel',
                    new StringType()
                ),
                new AddReturnTypeDeclaration('Nette\Bridges\ApplicationLatte\UIRuntime', 'initialize', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'getPersistentParams',
                    $arrayType
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'getPersistentComponents',
                    $arrayType
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'hasCallableMethod',
                    new BooleanType()
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\ComponentReflection', 'combineArgs', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'convertType',
                    new BooleanType()
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'parseAnnotation',
                    new UnionType([$arrayType, new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'getParameterType',
                    $arrayType
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ComponentReflection',
                    'hasAnnotation',
                    new BooleanType()
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\ComponentReflection', 'getMethods', $arrayType),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Control',
                    'getTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Control',
                    'createTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Control', 'templatePrepareFilters', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Control',
                    'flashMessage',
                    new ObjectType('stdClass')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Control', 'redrawControl', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Control', 'isControlInvalid', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Control', 'getSnippetId', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\Form',
                    'getPresenter',
                    new UnionType([new ObjectType('Nette\Application\UI\Presenter'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Form', 'signalReceived', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\IRenderable', 'redrawControl', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\IRenderable', 'isControlInvalid', new BooleanType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\ITemplate', 'render', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\ITemplate', 'getFile', new UnionType([
                    new StringType(),
                    new NullType(),
                ])),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\ITemplateFactory',
                    'createTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\Link', 'getDestination', new StringType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\Link', 'getParameters', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\UI\Link', '__toString', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\UI\MethodReflection',
                    'hasAnnotation',
                    new BooleanType()
                ),
                new AddReturnTypeDeclaration('Nette\Application\UI\IStatePersistent', 'loadState', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\IStatePersistent', 'saveState', new VoidType()),
                new AddReturnTypeDeclaration('Nette\Application\UI\ISignalReceiver', 'signalReceived', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\Routers\SimpleRouter',
                    'match',
                    new UnionType([new ObjectType('Nette\Application\Request'), new NullType()])
                ),
                new AddReturnTypeDeclaration('Nette\Application\Routers\SimpleRouter', 'getDefaults', $arrayType),
                new AddReturnTypeDeclaration('Nette\Application\Routers\SimpleRouter', 'getFlags', new IntegerType()),
                new AddReturnTypeDeclaration('Nette\Application\LinkGenerator', 'link', new StringType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\MicroPresenter',
                    'getContext',
                    new UnionType([new ObjectType('Nette\DI\Container'), new NullType()])
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\MicroPresenter',
                    'createTemplate',
                    new ObjectType('Nette\Application\UI\ITemplate')
                ),
                new AddReturnTypeDeclaration(
                    'Nette\Application\MicroPresenter',
                    'redirectUrl',
                    new ObjectType('Nette\Application\Responses\RedirectResponse')
                ),
                new AddReturnTypeDeclaration('Nette\Application\MicroPresenter', 'error', new VoidType()),
                new AddReturnTypeDeclaration(
                    'Nette\Application\MicroPresenter',
                    'getRequest',
                    new UnionType([new ObjectType('Nette\Application\Request'), new NullType()])
                ),
            ]),
        ]]);
};
