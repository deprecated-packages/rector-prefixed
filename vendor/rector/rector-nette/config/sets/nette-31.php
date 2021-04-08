<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use Rector\Composer\Rector\ChangePackageVersionComposerRector;
use Rector\Composer\Rector\RemovePackageComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Rector\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector;
use Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector;
use Rector\Transform\ValueObject\CallableInMethodCallToVariable;
use Rector\Transform\ValueObject\DimFetchAssignToMethodCall;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    // some attributes were added in nette 3.0, but only in one of latest patch versions; it's is safer to add them in 3.1
    $services->set(\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class)->call('configure', [[\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::ANNOTATION_TO_ATTRIBUTE => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // nette 3.0+, see https://github.com/nette/application/commit/d2471134ed909210de8a3e8559931902b1bee67b#diff-457507a8bdc046dd4f3a4aa1ca51794543fbb1e06f03825ab69ee864549a570c
        new \Rector\Php80\ValueObject\AnnotationToAttribute('inject', 'Nette\\DI\\Attributes\\Inject'),
        new \Rector\Php80\ValueObject\AnnotationToAttribute('persistent', 'Nette\\Application\\Attributes\\Persistent'),
        new \Rector\Php80\ValueObject\AnnotationToAttribute('crossOrigin', 'Nette\\Application\\Attributes\\CrossOrigin'),
    ])]]);
    $services->set(\Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::class)->call('configure', [[
        // see https://github.com/nette/caching/commit/5ffe263752af5ccf3866a28305e7b2669ab4da82
        \Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::CALLABLE_IN_METHOD_CALL_TO_VARIABLE => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\CallableInMethodCallToVariable('Nette\\Caching\\Cache', 'save', 1)]),
    ]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        'Nette\\Bridges\\ApplicationLatte\\Template' => 'Nette\\Bridges\\ApplicationLatte\\DefaultTemplate',
        // https://github.com/nette/application/compare/v3.0.7...v3.1.0
        'Nette\\Application\\IRouter' => 'Nette\\Routing\\Router',
        'Nette\\Application\\IResponse' => 'Nette\\Application\\Response',
        'Nette\\Application\\UI\\IRenderable' => 'Nette\\Application\\UI\\Renderable',
        'Nette\\Application\\UI\\ISignalReceiver' => 'Nette\\Application\\UI\\SignalReceiver',
        'Nette\\Application\\UI\\IStatePersistent' => 'Nette\\Application\\UI\\StatePersistent',
        'Nette\\Application\\UI\\ITemplate' => 'Nette\\Application\\UI\\Template',
        'Nette\\Application\\UI\\ITemplateFactory' => 'Nette\\Application\\UI\\TemplateFactory',
        'Nette\\Bridges\\ApplicationLatte\\ILatteFactory' => 'Nette\\Bridges\\ApplicationLatte\\LatteFactory',
        // https://github.com/nette/bootstrap/compare/v3.0.2...v3.1.0
        'Nette\\Configurator' => 'Nette\\Bootstrap\\Configurator',
        // https://github.com/nette/caching/compare/v3.0.2...v3.1.0
        'Nette\\Caching\\IBulkReader' => 'Nette\\Caching\\BulkReader',
        'Nette\\Caching\\IStorage' => 'Nette\\Caching\\Storage',
        'Nette\\Caching\\Storages\\IJournal' => 'Nette\\Caching\\Storages\\Journal',
        // https://github.com/nette/database/compare/v3.0.7...v3.1.1
        'Nette\\Database\\ISupplementalDriver' => 'Nette\\Database\\Driver',
        'Nette\\Database\\IConventions' => 'Nette\\Database\\Conventions',
        'Nette\\Database\\Context' => 'Nette\\Database\\Explorer',
        'Nette\\Database\\IRow' => 'Nette\\Database\\Row',
        'Nette\\Database\\IRowContainer' => 'Nette\\Database\\ResultSet',
        'Nette\\Database\\Table\\IRow' => 'Nette\\Database\\Table\\ActiveRow',
        'Nette\\Database\\Table\\IRowContainer' => 'Nette\\Database\\Table\\Selection',
        // https://github.com/nette/forms/compare/v3.0.7...v3.1.0-RC2
        'Nette\\Forms\\IControl' => 'Nette\\Forms\\Control',
        'Nette\\Forms\\IFormRenderer' => 'Nette\\Forms\\FormRenderer',
        'Nette\\Forms\\ISubmitterControl' => 'Nette\\Forms\\SubmitterControl',
        // https://github.com/nette/mail/compare/v3.0.1...v3.1.5
        'Nette\\Mail\\IMailer' => 'Nette\\Mail\\Mailer',
        // https://github.com/nette/security/compare/v3.0.5...v3.1.2
        'Nette\\Security\\IAuthorizator' => 'Nette\\Security\\Authorizator',
        'Nette\\Security\\Identity' => 'Nette\\Security\\SimpleIdentity',
        'Nette\\Security\\IResource' => 'Nette\\Security\\Resource',
        'Nette\\Security\\IRole' => 'Nette\\Security\\Role',
        // https://github.com/nette/utils/compare/v3.1.4...v3.2.1
        'Nette\\Utils\\IHtmlString' => 'Nette\\HtmlStringable',
        'Nette\\Localization\\ITranslator' => 'Nette\\Localization\\Translator',
        // https://github.com/nette/latte/compare/v2.5.5...v2.9.2
        'Latte\\ILoader' => 'Latte\\Loader',
        'Latte\\IMacro' => 'Latte\\Macro',
        'Latte\\Runtime\\IHtmlString' => 'Latte\\Runtime\\HtmlStringable',
        'Latte\\Runtime\\ISnippetBridge' => 'Latte\\Runtime\\SnippetBridge',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/nette/caching/commit/60281abf366c4ab76e9436dc1bfe2e402db18b67
        new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Caching\\Cache', 'start', 'capture'),
        // https://github.com/nette/forms/commit/faaaf8b8fd3408a274a9de7ca3f342091010ad5d
        new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Forms\\Container', 'addImage', 'addImageButton'),
        // https://github.com/nette/utils/commit/d0427c1811462dbb6c503143eabe5478b26685f7
        new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Utils\\Arrays', 'searchKey', 'getKeyOffset'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Configurator', 'addParameters', 'addStaticParameters'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/nette/utils/commit/8a4b795acd00f3f6754c28a73a7e776b60350c34
        new \Rector\Renaming\ValueObject\RenameStaticMethod('Nette\\Utils\\Callback', 'closure', 'Closure', 'fromCallable'),
    ])]]);
    $services->set(\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::DIM_FETCH_ASSIGN_TO_METHOD_CALL => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\DimFetchAssignToMethodCall('Nette\\Application\\Routers\\RouteList', 'Nette\\Application\\Routers\\Route', 'addRoute')])]]);
    $nullableTemplateType = new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Nette\\Application\\UI\\Template'), new \PHPStan\Type\NullType()]);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Nette\\Application\\UI\\Presenter', 'sendTemplate', 0, $nullableTemplateType)])]]);
    $services->set(\Rector\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector::class);
    $services->set(\Rector\Composer\Rector\ChangePackageVersionComposerRector::class)->call('configure', [[\Rector\Composer\Rector\ChangePackageVersionComposerRector::PACKAGES_AND_VERSIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // meta package
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/nette', '^3.1'),
        // https://github.com/nette/nette/blob/v3.0.0/composer.json vs https://github.com/nette/nette/blob/v3.1.0/composer.json
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/application', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/bootstrap', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/caching', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/database', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/di', '^3.0'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/finder', '^2.5'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/forms', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/http', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/mail', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/php-generator', '^3.5'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/robot-loader', '^3.3'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/safe-stream', '^2.4'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/security', '^3.1'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/tokenizer', '^3.0'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nette/utils', '^3.2'),
        new \Rector\Composer\ValueObject\PackageAndVersion('latte/latte', '^2.9'),
        new \Rector\Composer\ValueObject\PackageAndVersion('tracy/tracy', '^2.8'),
        // contributte
        new \Rector\Composer\ValueObject\PackageAndVersion('contributte/console', '^0.9'),
        new \Rector\Composer\ValueObject\PackageAndVersion('contributte/event-dispatcher', '^0.8'),
        new \Rector\Composer\ValueObject\PackageAndVersion('contributte/event-dispatcher-extra', '^0.8'),
        // nettrine
        new \Rector\Composer\ValueObject\PackageAndVersion('nettrine/annotations', '^0.7'),
        new \Rector\Composer\ValueObject\PackageAndVersion('nettrine/cache', '^0.3'),
    ])]]);
    $services->set(\Rector\Composer\Rector\RemovePackageComposerRector::class)->call('configure', [[\Rector\Composer\Rector\RemovePackageComposerRector::PACKAGE_NAMES => ['nette/component-model', 'nette/neon']]]);
};
