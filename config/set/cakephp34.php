<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // source: https://book.cakephp.org/3.0/en/appendices/3-4-migration-guide.html
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'params', 'getAttribute', null, ['params']),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'query', 'getQueryParams'),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'cookies', 'getCookie'),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'base', 'getAttribute', null, ['base']),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'webroot', 'getAttribute', null, ['webroot']),
        new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'here', 'getAttribute', null, ['here']),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', '_session', 'session')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Core\\InstanceConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Core\\StaticConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Console\\ConsoleOptionParser', 'command'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Console\\ConsoleOptionParser', 'description'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Console\\ConsoleOptionParser', 'epilog'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Connection', 'driver'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Connection', 'schemaCollection'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Connection', 'useSavePoints', 'isSavePointsEnabled', 'enableSavePoints'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Driver', 'autoQuoting', 'isAutoQuotingEnabled', 'enableAutoQuoting'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\FunctionExpression', 'name'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\QueryExpression', 'tieWith', 'getConjunction', 'setConjunction'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\ValuesExpression', 'columns'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\ValuesExpression', 'values'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\ValuesExpression', 'query'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Query', 'connection'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Query', 'selectTypeMap'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Query', 'bufferResults', 'isBufferedResultsEnabled', 'enableBufferedResults'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\CachedCollection', 'cacheMetadata'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\TableSchema', 'options'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\TableSchema', 'temporary', 'isTemporary', 'setTemporary'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\TypeMap', 'defaults'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\TypeMap', 'types'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\TypeMapTrait', 'typeMap'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Database\\TypeMapTrait', 'defaultTypes'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'name'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'cascadeCallbacks'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'source'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'target'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'conditions'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'bindingKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'foreignKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'dependent'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'joinType'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'property'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'strategy'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 'finder'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\BelongsToMany', 'targetForeignKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\BelongsToMany', 'saveStrategy'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\BelongsToMany', 'conditions'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\HasMany', 'saveStrategy'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\HasMany', 'foreignKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\HasMany', 'sort'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association\\HasOne', 'foreignKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\EagerLoadable', 'config'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\EagerLoadable', 'canBeJoined', 'canBeJoined', 'setCanBeJoined'),
        // note: will have to be called after setMatching() to keep the old behavior
        // ref: https://github.com/cakephp/cakephp/blob/4feee5463641e05c068b4d1d31dc5ee882b4240f/src/ORM/EagerLoader.php#L330
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\EagerLoadable', 'matching'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\EagerLoadable', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Locator\\TableLocator', 'config'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', 'eagerLoader'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', 'hydrate', 'isHydrationEnabled', 'enableHydration'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'table'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'alias'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'registryAlias'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'connection'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'schema'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'primaryKey'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'displayField'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'entityClass'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'entityClass'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'from'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'sender'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'replyTo'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'readReceipt'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'returnPath'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'to'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'cc'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'bcc'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'charset'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'headerCharset'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'emailPattern'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'subject'),
        // template: have to be changed manually, non A → B change + array case
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'viewRender', 'getViewRenderer', 'setViewRenderer'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'viewVars'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'theme'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'helpers'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'emailFormat'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'transport'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'messageId'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'domain'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'attachments'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'configTransport'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Email', 'profile'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Validation\\Validator', 'provider'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\StringTemplateTrait', 'templates'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'templatePath'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'layoutPath'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'plugin'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'helpers'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'theme'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'template'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'layout'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'options'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'name'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'className'),
        new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\View\\ViewBuilder', 'autoLayout', 'isAutoLayoutEnabled', 'enableAutoLayout'),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'param', 'getParam'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'query', 'getQuery'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'cookie', 'getCookie'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'method', 'getMethod'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Request', 'setInput', 'withBody'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'location', 'withLocation'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'disableCache', 'withDisabledCache'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'type', 'withType'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'charset', 'withCharset'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'cache', 'withCache'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'modified', 'withModified'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'expires', 'withExpires'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'sharable', 'withSharable'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'maxAge', 'withMaxAge'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'vary', 'withVary'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'etag', 'withEtag'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'compress', 'withCompression'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'length', 'withLength'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'mustRevalidate', 'withMustRevalidate'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'notModified', 'withNotModified'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'cookie', 'withCookie'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'file', 'withFile'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'download', 'withDownload'),
        # psr-7
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'header', 'getHeader'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'body', 'withBody'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'statusCode', 'getStatusCode'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', 'protocol', 'getProtocolVersion'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Event\\Event', 'name', 'getName'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Event\\Event', 'subject', 'getSubject'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Event\\Event', 'result', 'getResult'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Event\\Event', 'data', 'getData'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\View\\Helper\\FormHelper', 'input', 'control'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\View\\Helper\\FormHelper', 'inputs', 'controls'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\View\\Helper\\FormHelper', 'allInputs', 'allControls'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Mailer\\Mailer', 'layout', 'setLayout'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Routing\\Route\\Route', 'parse', 'parseRequest'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Routing\\Router', 'parse', 'parseRequest'),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Cake\\Mailer\\MailerAwareTrait', 'getMailer', 'protected'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Cake\\View\\CellTrait', 'cell', 'protected')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\Table' => '_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\TableSchema']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\NormalToFluent('_PhpScoperb75b35f52b74\\Cake\\Network\\Response', ['withLocation', 'withHeader', 'withDisabledCache', 'withType', 'withCharset', 'withCache', 'withModified', 'withExpires', 'withSharable', 'withMaxAge', 'withVary', 'withEtag', 'withCompression', 'withLength', 'withMustRevalidate', 'withNotModified', 'withCookie', 'withFile', 'withDownload'])])]]);
};
