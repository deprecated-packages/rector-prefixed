<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\NormalToFluentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // source: https://book.cakephp.org/3.0/en/appendices/3-4-migration-guide.html
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'params', 'getAttribute', null, ['params']),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'query', 'getQueryParams'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'cookies', 'getCookie'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'base', 'getAttribute', null, ['base']),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'webroot', 'getAttribute', null, ['webroot']),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'here', 'getAttribute', null, ['here']),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', '_session', 'session')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\InstanceConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\StaticConfigTrait', 'config', null, null, 2, 'array'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Console\\ConsoleOptionParser', 'command'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Console\\ConsoleOptionParser', 'description'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Console\\ConsoleOptionParser', 'epilog'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Connection', 'driver'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Connection', 'schemaCollection'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Connection', 'useSavePoints', 'isSavePointsEnabled', 'enableSavePoints'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Driver', 'autoQuoting', 'isAutoQuotingEnabled', 'enableAutoQuoting'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Expression\\FunctionExpression', 'name'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Expression\\QueryExpression', 'tieWith', 'getConjunction', 'setConjunction'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Expression\\ValuesExpression', 'columns'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Expression\\ValuesExpression', 'values'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Expression\\ValuesExpression', 'query'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Query', 'connection'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Query', 'selectTypeMap'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Query', 'bufferResults', 'isBufferedResultsEnabled', 'enableBufferedResults'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Schema\\CachedCollection', 'cacheMetadata'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Schema\\TableSchema', 'options'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Schema\\TableSchema', 'temporary', 'isTemporary', 'setTemporary'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\TypeMap', 'defaults'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\TypeMap', 'types'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\TypeMapTrait', 'typeMap'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\TypeMapTrait', 'defaultTypes'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'name'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'cascadeCallbacks'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'source'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'target'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'conditions'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'bindingKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'foreignKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'dependent'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'joinType'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'property'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'strategy'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 'finder'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\BelongsToMany', 'targetForeignKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\BelongsToMany', 'saveStrategy'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\BelongsToMany', 'conditions'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\HasMany', 'saveStrategy'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\HasMany', 'foreignKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\HasMany', 'sort'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association\\HasOne', 'foreignKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\EagerLoadable', 'config'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\EagerLoadable', 'canBeJoined', 'canBeJoined', 'setCanBeJoined'),
        // note: will have to be called after setMatching() to keep the old behavior
        // ref: https://github.com/cakephp/cakephp/blob/4feee5463641e05c068b4d1d31dc5ee882b4240f/src/ORM/EagerLoader.php#L330
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\EagerLoadable', 'matching'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\EagerLoadable', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Locator\\TableLocator', 'config'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', 'eagerLoader'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', 'hydrate', 'isHydrationEnabled', 'enableHydration'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', 'autoFields', 'isAutoFieldsEnabled', 'enableAutoFields'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'table'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'alias'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'registryAlias'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'connection'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'schema'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'primaryKey'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'displayField'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'entityClass'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'entityClass'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'from'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'sender'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'replyTo'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'readReceipt'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'returnPath'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'to'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'cc'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'bcc'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'charset'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'headerCharset'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'emailPattern'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'subject'),
        // template: have to be changed manually, non A → B change + array case
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'viewRender', 'getViewRenderer', 'setViewRenderer'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'viewVars'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'theme'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'helpers'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'emailFormat'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'transport'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'messageId'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'domain'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'attachments'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'configTransport'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Email', 'profile'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\Validation\\Validator', 'provider'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\StringTemplateTrait', 'templates'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'templatePath'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'layoutPath'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'plugin'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'helpers'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'theme'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'template'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'layout'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'options'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'name'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'className'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\ViewBuilder', 'autoLayout', 'isAutoLayoutEnabled', 'enableAutoLayout'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'param', 'getParam'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'data', 'getData'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'query', 'getQuery'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'cookie', 'getCookie'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'method', 'getMethod'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request', 'setInput', 'withBody'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'location', 'withLocation'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'disableCache', 'withDisabledCache'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'type', 'withType'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'charset', 'withCharset'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'cache', 'withCache'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'modified', 'withModified'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'expires', 'withExpires'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'sharable', 'withSharable'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'maxAge', 'withMaxAge'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'vary', 'withVary'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'etag', 'withEtag'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'compress', 'withCompression'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'length', 'withLength'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'mustRevalidate', 'withMustRevalidate'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'notModified', 'withNotModified'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'cookie', 'withCookie'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'file', 'withFile'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'download', 'withDownload'),
        # psr-7
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'header', 'getHeader'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'body', 'withBody'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'statusCode', 'getStatusCode'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', 'protocol', 'getProtocolVersion'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Event\\Event', 'name', 'getName'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Event\\Event', 'subject', 'getSubject'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Event\\Event', 'result', 'getResult'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Event\\Event', 'data', 'getData'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\Helper\\FormHelper', 'input', 'control'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\Helper\\FormHelper', 'inputs', 'controls'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\Helper\\FormHelper', 'allInputs', 'allControls'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\Mailer', 'layout', 'setLayout'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Routing\\Route\\Route', 'parse', 'parseRequest'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Cake\\Routing\\Router', 'parse', 'parseRequest'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper2a4e7ab1ecbc\\Cake\\Mailer\\MailerAwareTrait', 'getMailer', 'protected'), new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper2a4e7ab1ecbc\\Cake\\View\\CellTrait', 'cell', 'protected')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Schema\\Table' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\Schema\\TableSchema']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\NormalToFluent('_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Response', ['withLocation', 'withHeader', 'withDisabledCache', 'withType', 'withCharset', 'withCache', 'withModified', 'withExpires', 'withSharable', 'withMaxAge', 'withVary', 'withEtag', 'withCompression', 'withLength', 'withMustRevalidate', 'withNotModified', 'withCookie', 'withFile', 'withDownload'])])]]);
};
