<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use Rector\Composer\Rector\ChangePackageVersionComposerRector;
use Rector\Composer\Rector\RemovePackageComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Rector\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector;
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
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::class)->call('configure', [[
        // see https://github.com/nette/caching/commit/5ffe263752af5ccf3866a28305e7b2669ab4da82
        \Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::CALLABLE_IN_METHOD_CALL_TO_VARIABLE => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\CallableInMethodCallToVariable('RectorPrefix20210320\\Nette\\Caching\\Cache', 'save', 1)]),
    ]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        'RectorPrefix20210320\\Nette\\Bridges\\ApplicationLatte\\Template' => 'RectorPrefix20210320\\Nette\\Bridges\\ApplicationLatte\\DefaultTemplate',
        // https://github.com/nette/application/compare/v3.0.7...v3.1.0
        'RectorPrefix20210320\\Nette\\Application\\IRouter' => 'RectorPrefix20210320\\Nette\\Routing\\Router',
        'RectorPrefix20210320\\Nette\\Application\\IResponse' => 'RectorPrefix20210320\\Nette\\Application\\Response',
        'RectorPrefix20210320\\Nette\\Application\\UI\\IRenderable' => 'RectorPrefix20210320\\Nette\\Application\\UI\\Renderable',
        'RectorPrefix20210320\\Nette\\Application\\UI\\ISignalReceiver' => 'RectorPrefix20210320\\Nette\\Application\\UI\\SignalReceiver',
        'RectorPrefix20210320\\Nette\\Application\\UI\\IStatePersistent' => 'RectorPrefix20210320\\Nette\\Application\\UI\\StatePersistent',
        'RectorPrefix20210320\\Nette\\Application\\UI\\ITemplate' => 'RectorPrefix20210320\\Nette\\Application\\UI\\Template',
        'RectorPrefix20210320\\Nette\\Application\\UI\\ITemplateFactory' => 'RectorPrefix20210320\\Nette\\Application\\UI\\TemplateFactory',
        'RectorPrefix20210320\\Nette\\Bridges\\ApplicationLatte\\ILatteFactory' => 'RectorPrefix20210320\\Nette\\Bridges\\ApplicationLatte\\LatteFactory',
        // https://github.com/nette/bootstrap/compare/v3.0.2...v3.1.0
        'RectorPrefix20210320\\Nette\\Configurator' => 'RectorPrefix20210320\\Nette\\Bootstrap\\Configurator',
        // https://github.com/nette/caching/compare/v3.0.2...v3.1.0
        'RectorPrefix20210320\\Nette\\Caching\\IBulkReader' => 'RectorPrefix20210320\\Nette\\Caching\\BulkReader',
        'RectorPrefix20210320\\Nette\\Caching\\IStorage' => 'RectorPrefix20210320\\Nette\\Caching\\Storage',
        'RectorPrefix20210320\\Nette\\Caching\\Storages\\IJournal' => 'RectorPrefix20210320\\Nette\\Caching\\Storages\\Journal',
        // https://github.com/nette/database/compare/v3.0.7...v3.1.1
        'RectorPrefix20210320\\Nette\\Database\\ISupplementalDriver' => 'RectorPrefix20210320\\Nette\\Database\\Driver',
        'RectorPrefix20210320\\Nette\\Database\\IConventions' => 'RectorPrefix20210320\\Nette\\Database\\Conventions',
        'RectorPrefix20210320\\Nette\\Database\\Context' => 'RectorPrefix20210320\\Nette\\Database\\Explorer',
        'RectorPrefix20210320\\Nette\\Database\\IRow' => 'RectorPrefix20210320\\Nette\\Database\\Row',
        'RectorPrefix20210320\\Nette\\Database\\IRowContainer' => 'RectorPrefix20210320\\Nette\\Database\\ResultSet',
        'RectorPrefix20210320\\Nette\\Database\\Table\\IRow' => 'RectorPrefix20210320\\Nette\\Database\\Table\\ActiveRow',
        'RectorPrefix20210320\\Nette\\Database\\Table\\IRowContainer' => 'RectorPrefix20210320\\Nette\\Database\\Table\\Selection',
        // https://github.com/nette/forms/compare/v3.0.7...v3.1.0-RC2
        'RectorPrefix20210320\\Nette\\Forms\\IControl' => 'RectorPrefix20210320\\Nette\\Forms\\Control',
        'RectorPrefix20210320\\Nette\\Forms\\IFormRenderer' => 'RectorPrefix20210320\\Nette\\Forms\\FormRenderer',
        'RectorPrefix20210320\\Nette\\Forms\\ISubmitterControl' => 'RectorPrefix20210320\\Nette\\Forms\\SubmitterControl',
        // https://github.com/nette/mail/compare/v3.0.1...v3.1.5
        'RectorPrefix20210320\\Nette\\Mail\\IMailer' => 'RectorPrefix20210320\\Nette\\Mail\\Mailer',
        // https://github.com/nette/security/compare/v3.0.5...v3.1.2
        'RectorPrefix20210320\\Nette\\Security\\IAuthorizator' => 'RectorPrefix20210320\\Nette\\Security\\Authorizator',
        'RectorPrefix20210320\\Nette\\Security\\Identity' => 'RectorPrefix20210320\\Nette\\Security\\SimpleIdentity',
        'RectorPrefix20210320\\Nette\\Security\\IResource' => 'RectorPrefix20210320\\Nette\\Security\\Resource',
        'RectorPrefix20210320\\Nette\\Security\\IRole' => 'RectorPrefix20210320\\Nette\\Security\\Role',
        // https://github.com/nette/utils/compare/v3.1.4...v3.2.1
        'RectorPrefix20210320\\Nette\\Utils\\IHtmlString' => 'RectorPrefix20210320\\Nette\\HtmlStringable',
        'RectorPrefix20210320\\Nette\\Localization\\ITranslator' => 'RectorPrefix20210320\\Nette\\Localization\\Translator',
        // https://github.com/nette/latte/compare/v2.5.5...v2.9.2
        'RectorPrefix20210320\\Latte\\ILoader' => 'RectorPrefix20210320\\Latte\\Loader',
        'RectorPrefix20210320\\Latte\\IMacro' => 'RectorPrefix20210320\\Latte\\Macro',
        'RectorPrefix20210320\\Latte\\Runtime\\IHtmlString' => 'RectorPrefix20210320\\Latte\\Runtime\\HtmlStringable',
        'RectorPrefix20210320\\Latte\\Runtime\\ISnippetBridge' => 'RectorPrefix20210320\\Latte\\Runtime\\SnippetBridge',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/nette/caching/commit/60281abf366c4ab76e9436dc1bfe2e402db18b67
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Nette\\Caching\\Cache', 'start', 'capture'),
        // https://github.com/nette/forms/commit/faaaf8b8fd3408a274a9de7ca3f342091010ad5d
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Nette\\Forms\\Container', 'addImage', 'addImageButton'),
        // https://github.com/nette/utils/commit/d0427c1811462dbb6c503143eabe5478b26685f7
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Nette\\Utils\\Arrays', 'searchKey', 'getKeyOffset'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20210320\\Nette\\Configurator', 'addParameters', 'addStaticParameters'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/nette/utils/commit/8a4b795acd00f3f6754c28a73a7e776b60350c34
        new \Rector\Renaming\ValueObject\RenameStaticMethod('RectorPrefix20210320\\Nette\\Utils\\Callback', 'closure', 'Closure', 'fromCallable'),
    ])]]);
    $services->set(\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::DIM_FETCH_ASSIGN_TO_METHOD_CALL => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\DimFetchAssignToMethodCall('RectorPrefix20210320\\Nette\\Application\\Routers\\RouteList', 'RectorPrefix20210320\\Nette\\Application\\Routers\\Route', 'addRoute')])]]);
    $nullableTemplateType = new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('RectorPrefix20210320\\Nette\\Application\\UI\\Template'), new \PHPStan\Type\NullType()]);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('RectorPrefix20210320\\Nette\\Application\\UI\\Presenter', 'sendTemplate', 0, $nullableTemplateType)])]]);
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
