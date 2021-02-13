<?php

declare (strict_types=1);
namespace RectorPrefix20210213;

use PHPStan\Type\ObjectType;
use Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector;
use Rector\NetteToSymfony\Rector\ClassMethod\RouterListToControllerAnnotationsRector;
use Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector;
use Rector\NetteToSymfony\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector;
use Rector\NetteToSymfony\Rector\MethodCall\FromRequestGetParameterToAttributesGetRector;
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/nette-to-symfony-doctrine.php');
    $containerConfigurator->import(__DIR__ . '/nette-control-to-symfony-controller.php');
    $containerConfigurator->import(__DIR__ . '/nette-tester-to-phpunit.php');
    $containerConfigurator->import(__DIR__ . '/kdyby-to-symfony.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\Interface_\DeleteFactoryInterfaceRector::class);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector::class);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\FromRequestGetParameterToAttributesGetRector::class);
    $services->set(\Rector\NetteToSymfony\Rector\ClassMethod\RouterListToControllerAnnotationsRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Nette\\Application\\IPresenter', 'run', new \PHPStan\Type\ObjectType('Symfony\\Component\\HttpFoundation\\Response'))])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Nette\\Application\\Request' => 'Symfony\\Component\\HttpFoundation\\Request', 'Nette\\Http\\Request' => 'Symfony\\Component\\HttpFoundation\\Request', 'Nette\\Http\\IRequest' => 'Symfony\\Component\\HttpFoundation\\Request', 'Nette\\Application\\UI\\Presenter' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController', 'Nette\\Application\\IResponse' => 'Symfony\\Component\\HttpFoundation\\Response']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Application\\IPresenter', 'run', '__invoke'), new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\DI\\Container', 'getByType', 'get'), new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Configurator', 'addConfig', 'load'), new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Config\\Loader\\LoaderInterface', 'addConfig', 'load')])]]);
    $services->set(\Rector\Removing\Rector\Class_\RemoveInterfacesRector::class)->call('configure', [[\Rector\Removing\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => ['Nette\\Application\\IPresenter']]]);
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S100_CONTINUE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_CONTINUE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S101_SWITCHING_PROTOCOLS', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_SWITCHING_PROTOCOLS'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S102_PROCESSING', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PROCESSING'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S200_OK', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_OK'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S201_CREATED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_CREATED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S202_ACCEPTED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_ACCEPTED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S203_NON_AUTHORITATIVE_INFORMATION', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NON_AUTHORITATIVE_INFORMATION'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S204_NO_CONTENT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NO_CONTENT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S205_RESET_CONTENT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_RESET_CONTENT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S206_PARTIAL_CONTENT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PARTIAL_CONTENT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S207_MULTI_STATUS', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_MULTI_STATUS'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S208_ALREADY_REPORTED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_ALREADY_REPORTED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S226_IM_USED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_IM_USED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S300_MULTIPLE_CHOICES', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_MULTIPLE_CHOICES'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S301_MOVED_PERMANENTLY', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_MOVED_PERMANENTLY'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S302_FOUND', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_FOUND'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S303_SEE_OTHER', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_SEE_OTHER'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S303_POST_GET', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_SEE_OTHER'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S304_NOT_MODIFIED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NOT_MODIFIED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S305_USE_PROXY', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_USE_PROXY'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S307_TEMPORARY_REDIRECT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_TEMPORARY_REDIRECT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S308_PERMANENT_REDIRECT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PERMANENTLY_REDIRECT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S400_BAD_REQUEST', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_BAD_REQUEST'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S401_UNAUTHORIZED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_UNAUTHORIZED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S402_PAYMENT_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PAYMENT_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S403_FORBIDDEN', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_FORBIDDEN'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S404_NOT_FOUND', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NOT_FOUND'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S405_METHOD_NOT_ALLOWED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_METHOD_NOT_ALLOWED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S406_NOT_ACCEPTABLE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NOT_ACCEPTABLE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S407_PROXY_AUTHENTICATION_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PROXY_AUTHENTICATION_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S408_REQUEST_TIMEOUT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_REQUEST_TIMEOUT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S409_CONFLICT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_CONFLICT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S410_GONE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_GONE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S411_LENGTH_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_LENGTH_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S412_PRECONDITION_FAILED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PRECONDITION_FAILED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S413_REQUEST_ENTITY_TOO_LARGE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_REQUEST_ENTITY_TOO_LARGE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S414_REQUEST_URI_TOO_LONG', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_REQUEST_URI_TOO_LONG'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S415_UNSUPPORTED_MEDIA_TYPE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_UNSUPPORTED_MEDIA_TYPE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S416_REQUESTED_RANGE_NOT_SATISFIABLE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_REQUESTED_RANGE_NOT_SATISFIABLE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S417_EXPECTATION_FAILED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_EXPECTATION_FAILED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S421_MISDIRECTED_REQUEST', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_MISDIRECTED_REQUEST'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S422_UNPROCESSABLE_ENTITY', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_UNPROCESSABLE_ENTITY'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S423_LOCKED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_LOCKED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S424_FAILED_DEPENDENCY', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_FAILED_DEPENDENCY'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S426_UPGRADE_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_UPGRADE_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S428_PRECONDITION_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_PRECONDITION_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S429_TOO_MANY_REQUESTS', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_TOO_MANY_REQUESTS'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S431_REQUEST_HEADER_FIELDS_TOO_LARGE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S451_UNAVAILABLE_FOR_LEGAL_REASONS', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_UNAVAILABLE_FOR_LEGAL_REASONS'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S500_INTERNAL_SERVER_ERROR', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_INTERNAL_SERVER_ERROR'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S501_NOT_IMPLEMENTED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NOT_IMPLEMENTED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S502_BAD_GATEWAY', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_BAD_GATEWAY'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S503_SERVICE_UNAVAILABLE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_SERVICE_UNAVAILABLE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S504_GATEWAY_TIMEOUT', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_GATEWAY_TIMEOUT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S505_HTTP_VERSION_NOT_SUPPORTED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_VERSION_NOT_SUPPORTED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S506_VARIANT_ALSO_NEGOTIATES', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S507_INSUFFICIENT_STORAGE', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_INSUFFICIENT_STORAGE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S508_LOOP_DETECTED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_LOOP_DETECTED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S510_NOT_EXTENDED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NOT_EXTENDED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Response', 'S511_NETWORK_AUTHENTICATION_REQUIRED', 'Symfony\\Component\\HttpFoundation\\Response', 'HTTP_NETWORK_AUTHENTICATION_REQUIRED'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'GET', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_GET'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'POST', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_POST'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'HEAD', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_HEAD'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'PUT', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_PUT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'DELETE', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_DELETE'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'PATCH', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_PATCH'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch('Nette\\Http\\*Request', 'OPTIONS', 'Symfony\\Component\\HttpFoundation\\Request', 'METHOD_OPTIONS')])]]);
    $services->set(\Rector\NetteToSymfony\Rector\Class_\FormControlToControllerAndFormTypeRector::class);
};
