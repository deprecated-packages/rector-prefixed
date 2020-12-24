<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScopere8e811afab72\\Cake\\ORM\\Association', [
        'bindingKey' => 'setBindingKey',
        'cascadeCallbacks' => 'setCascadeCallbacks',
        'className' => 'setClassName',
        'conditions' => 'setConditions',
        'dependent' => 'setDependent',
        'finder' => 'setFinder',
        'foreignKey' => 'setForeignKey',
        'joinType' => 'setJoinType',
        'propertyName' => 'setProperty',
        'sourceTable' => 'setSource',
        'strategy' => 'setStrategy',
        'targetTable' => 'setTarget',
        # BelongsToMany and HasMany only
        'saveStrategy' => 'setSaveStrategy',
        'sort' => 'setSort',
        # BelongsToMany only
        'targetForeignKey' => 'setTargetForeignKey',
        'through' => 'setThrough',
    ]), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScopere8e811afab72\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScopere8e811afab72\\Cake\\ORM\\Association', [
        'bindingKey' => 'setBindingKey',
        'cascadeCallbacks' => 'setCascadeCallbacks',
        'className' => 'setClassName',
        'conditions' => 'setConditions',
        'dependent' => 'setDependent',
        'finder' => 'setFinder',
        'foreignKey' => 'setForeignKey',
        'joinType' => 'setJoinType',
        'propertyName' => 'setProperty',
        'sourceTable' => 'setSource',
        'strategy' => 'setStrategy',
        'targetTable' => 'setTarget',
        # BelongsToMany and HasMany only
        'saveStrategy' => 'setSaveStrategy',
        'sort' => 'setSort',
        # BelongsToMany only
        'targetForeignKey' => 'setTargetForeignKey',
        'through' => 'setThrough',
    ]), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScopere8e811afab72\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'belongsTo', '_PhpScopere8e811afab72\\Cake\\ORM\\Association', 2), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'belongsToMany', '_PhpScopere8e811afab72\\Cake\\ORM\\Association', 2), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'hasMany', '_PhpScopere8e811afab72\\Cake\\ORM\\Association', 2), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'hasOne', '_PhpScopere8e811afab72\\Cake\\ORM\\Association', 2), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScopere8e811afab72\\Cake\\ORM\\Table', 'find', '_PhpScopere8e811afab72\\Cake\\ORM\\Query', 2)])]]);
};
