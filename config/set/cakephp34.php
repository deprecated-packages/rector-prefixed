<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // source: https://book.cakephp.org/3.0/en/appendices/3-4-migration-guide.html
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'params', 'getAttribute', null, ['params']),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'query', 'getQueryParams'),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'cookies', 'getCookie'),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'base', 'getAttribute', null, ['base']),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'webroot', 'getAttribute', null, ['webroot']),
        new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'here', 'getAttribute', null, ['here']),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty('_PhpScopere8e811afab72\\Cake\\Network\\Request', '_session', 'session')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Core\\InstanceConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Core\\StaticConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Console\\ConsoleOptionParser', 'command'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Console\\ConsoleOptionParser', 'description'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Console\\ConsoleOptionParser', 'epilog'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Connection', 'driver'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Connection', 'schemaCollection'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Connection', 'useSavePoints', 'isSavePointsEnabled', 'enableSavePoints'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Driver', 'autoQuoting', 'isAutoQuotingEnabled', 'enableAutoQuoting'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\FunctionExpression', 'name'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\QueryExpression', 'tieWith', 'getConjunction', 'setConjunction'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\ValuesExpression', 'columns'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\ValuesExpression', 'values'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\ValuesExpression', 'query'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Query', 'connection'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Query', 'selectTypeMap'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Query', 'bufferResults', 'isBufferedResultsEnabled', 'enableBufferedResults'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Schema\\CachedCollection', 'cacheMetadata'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Schema\\TableSchema', 'options'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\Schema\\TableSchema', 'temporary', 'isTemporary', 'setTemporary'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\TypeMap', 'defaults'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\TypeMap', 'types'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\TypeMapTrait', 'typeMap'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Database\\TypeMapTrait', 'defaultTypes'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'name'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'cascadeCallbacks'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'source'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'target'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'conditions'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'bindingKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'foreignKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'dependent'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'joinType'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'property'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'strategy'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association', 'finder'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\BelongsToMany', 'targetForeignKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\BelongsToMany', 'saveStrategy'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\BelongsToMany', 'conditions'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\HasMany', 'saveStrategy'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\HasMany', 'foreignKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\HasMany', 'sort'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Association\\HasOne', 'foreignKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\EagerLoadable', 'config'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\EagerLoadable', 'canBeJoined', 'canBeJoined', 'setCanBeJoined'),
        // note: will have to be called after setMatching() to keep the old behavior
        // ref: https://github.com/cakephp/cakephp/blob/4feee5463641e05c068b4d1d31dc5ee882b4240f/src/ORM/EagerLoader.php#L330
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\EagerLoadable', 'matching'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\EagerLoadable', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Locator\\TableLocator', 'config'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Query', 'eagerLoader'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Query', 'hydrate', 'isHydrationEnabled', 'enableHydration'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Query', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'table'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'alias'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'registryAlias'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'connection'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'schema'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'primaryKey'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'displayField'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'entityClass'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'entityClass'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'from'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'sender'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'replyTo'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'readReceipt'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'returnPath'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'to'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'cc'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'bcc'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'charset'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'headerCharset'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'emailPattern'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'subject'),
        // template: have to be changed manually, non A → B change + array case
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'viewRender', 'getViewRenderer', 'setViewRenderer'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'viewVars'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'theme'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'helpers'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'emailFormat'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'transport'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'messageId'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'domain'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'attachments'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'configTransport'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Mailer\\Email', 'profile'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Validation\\Validator', 'provider'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\StringTemplateTrait', 'templates'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'templatePath'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'layoutPath'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'plugin'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'helpers'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'theme'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'template'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'layout'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'options'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'name'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'className'),
        new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\View\\ViewBuilder', 'autoLayout', 'isAutoLayoutEnabled', 'enableAutoLayout'),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'param', 'getParam'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'query', 'getQuery'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'cookie', 'getCookie'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'method', 'getMethod'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Request', 'setInput', 'withBody'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'location', 'withLocation'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'disableCache', 'withDisabledCache'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'type', 'withType'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'charset', 'withCharset'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'cache', 'withCache'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'modified', 'withModified'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'expires', 'withExpires'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'sharable', 'withSharable'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'maxAge', 'withMaxAge'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'vary', 'withVary'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'etag', 'withEtag'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'compress', 'withCompression'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'length', 'withLength'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'mustRevalidate', 'withMustRevalidate'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'notModified', 'withNotModified'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'cookie', 'withCookie'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'file', 'withFile'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'download', 'withDownload'),
        # psr-7
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'header', 'getHeader'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'body', 'withBody'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'statusCode', 'getStatusCode'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Network\\Response', 'protocol', 'getProtocolVersion'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Event\\Event', 'name', 'getName'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Event\\Event', 'subject', 'getSubject'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Event\\Event', 'result', 'getResult'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Event\\Event', 'data', 'getData'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\View\\Helper\\FormHelper', 'input', 'control'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\View\\Helper\\FormHelper', 'inputs', 'controls'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\View\\Helper\\FormHelper', 'allInputs', 'allControls'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Mailer\\Mailer', 'layout', 'setLayout'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Routing\\Route\\Route', 'parse', 'parseRequest'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Routing\\Router', 'parse', 'parseRequest'),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Cake\\Mailer\\MailerAwareTrait', 'getMailer', 'protected'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Cake\\View\\CellTrait', 'cell', 'protected')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Cake\\Database\\Schema\\Table' => '_PhpScopere8e811afab72\\Cake\\Database\\Schema\\TableSchema']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\NormalToFluent('_PhpScopere8e811afab72\\Cake\\Network\\Response', ['withLocation', 'withHeader', 'withDisabledCache', 'withType', 'withCharset', 'withCache', 'withModified', 'withExpires', 'withSharable', 'withMaxAge', 'withVary', 'withEtag', 'withCompression', 'withLength', 'withMustRevalidate', 'withNotModified', 'withCookie', 'withFile', 'withDownload'])])]]);
};
