<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyToMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // source: https://book.cakephp.org/3.0/en/appendices/3-4-migration-guide.html
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'params', 'getAttribute', null, ['params']),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'query', 'getQueryParams'),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'cookies', 'getCookie'),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'base', 'getAttribute', null, ['base']),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'webroot', 'getAttribute', null, ['webroot']),
        new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'here', 'getAttribute', null, ['here']),
    ])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameProperty('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', '_session', 'session')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Core\\InstanceConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Core\\StaticConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Console\\ConsoleOptionParser', 'command'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Console\\ConsoleOptionParser', 'description'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Console\\ConsoleOptionParser', 'epilog'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Connection', 'driver'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Connection', 'schemaCollection'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Connection', 'useSavePoints', 'isSavePointsEnabled', 'enableSavePoints'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Driver', 'autoQuoting', 'isAutoQuotingEnabled', 'enableAutoQuoting'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Expression\\FunctionExpression', 'name'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Expression\\QueryExpression', 'tieWith', 'getConjunction', 'setConjunction'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Expression\\ValuesExpression', 'columns'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Expression\\ValuesExpression', 'values'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Expression\\ValuesExpression', 'query'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Query', 'connection'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Query', 'selectTypeMap'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Query', 'bufferResults', 'isBufferedResultsEnabled', 'enableBufferedResults'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Schema\\CachedCollection', 'cacheMetadata'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Schema\\TableSchema', 'options'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\Schema\\TableSchema', 'temporary', 'isTemporary', 'setTemporary'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\TypeMap', 'defaults'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\TypeMap', 'types'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\TypeMapTrait', 'typeMap'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Database\\TypeMapTrait', 'defaultTypes'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'name'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'cascadeCallbacks'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'source'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'target'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'conditions'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'bindingKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'foreignKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'dependent'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'joinType'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'property'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'strategy'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 'finder'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\BelongsToMany', 'targetForeignKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\BelongsToMany', 'saveStrategy'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\BelongsToMany', 'conditions'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\HasMany', 'saveStrategy'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\HasMany', 'foreignKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\HasMany', 'sort'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association\\HasOne', 'foreignKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\EagerLoadable', 'config'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\EagerLoadable', 'canBeJoined', 'canBeJoined', 'setCanBeJoined'),
        // note: will have to be called after setMatching() to keep the old behavior
        // ref: https://github.com/cakephp/cakephp/blob/4feee5463641e05c068b4d1d31dc5ee882b4240f/src/ORM/EagerLoader.php#L330
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\EagerLoadable', 'matching'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\EagerLoadable', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Locator\\TableLocator', 'config'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', 'eagerLoader'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', 'hydrate', 'isHydrationEnabled', 'enableHydration'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'table'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'alias'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'registryAlias'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'connection'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'schema'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'primaryKey'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'displayField'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'entityClass'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'entityClass'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'from'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'sender'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'replyTo'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'readReceipt'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'returnPath'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'to'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'cc'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'bcc'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'charset'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'headerCharset'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'emailPattern'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'subject'),
        // template: have to be changed manually, non A → B change + array case
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'viewRender', 'getViewRenderer', 'setViewRenderer'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'viewVars'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'theme'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'helpers'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'emailFormat'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'transport'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'messageId'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'domain'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'attachments'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'configTransport'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Email', 'profile'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\Validation\\Validator', 'provider'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\StringTemplateTrait', 'templates'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'templatePath'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'layoutPath'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'plugin'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'helpers'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'theme'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'template'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'layout'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'options'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'name'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'className'),
        new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a6b37af0871\\Cake\\View\\ViewBuilder', 'autoLayout', 'isAutoLayoutEnabled', 'enableAutoLayout'),
    ])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'param', 'getParam'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'query', 'getQuery'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'cookie', 'getCookie'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'method', 'getMethod'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Request', 'setInput', 'withBody'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'location', 'withLocation'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'disableCache', 'withDisabledCache'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'type', 'withType'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'charset', 'withCharset'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'cache', 'withCache'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'modified', 'withModified'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'expires', 'withExpires'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'sharable', 'withSharable'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'maxAge', 'withMaxAge'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'vary', 'withVary'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'etag', 'withEtag'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'compress', 'withCompression'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'length', 'withLength'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'mustRevalidate', 'withMustRevalidate'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'notModified', 'withNotModified'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'cookie', 'withCookie'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'file', 'withFile'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'download', 'withDownload'),
        # psr-7
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'header', 'getHeader'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'body', 'withBody'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'statusCode', 'getStatusCode'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', 'protocol', 'getProtocolVersion'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Event\\Event', 'name', 'getName'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Event\\Event', 'subject', 'getSubject'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Event\\Event', 'result', 'getResult'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Event\\Event', 'data', 'getData'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\View\\Helper\\FormHelper', 'input', 'control'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\View\\Helper\\FormHelper', 'inputs', 'controls'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\View\\Helper\\FormHelper', 'allInputs', 'allControls'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Mailer\\Mailer', 'layout', 'setLayout'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Routing\\Route\\Route', 'parse', 'parseRequest'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Cake\\Routing\\Router', 'parse', 'parseRequest'),
    ])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Cake\\Mailer\\MailerAwareTrait', 'getMailer', 'protected'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Cake\\View\\CellTrait', 'cell', 'protected')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\Cake\\Database\\Schema\\Table' => '_PhpScoper0a6b37af0871\\Cake\\Database\\Schema\\TableSchema']]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\NormalToFluent('_PhpScoper0a6b37af0871\\Cake\\Network\\Response', ['withLocation', 'withHeader', 'withDisabledCache', 'withType', 'withCharset', 'withCache', 'withModified', 'withExpires', 'withSharable', 'withMaxAge', 'withVary', 'withEtag', 'withCompression', 'withLength', 'withMustRevalidate', 'withNotModified', 'withCookie', 'withFile', 'withDownload'])])]]);
};
