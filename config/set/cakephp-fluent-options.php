<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'belongsTo', '_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 2), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'belongsToMany', '_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 2), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'hasMany', '_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 2), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'hasOne', '_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Association', 2), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Table', 'find', '_PhpScoper2a4e7ab1ecbc\\Cake\\ORM\\Query', 2)])]]);
};
