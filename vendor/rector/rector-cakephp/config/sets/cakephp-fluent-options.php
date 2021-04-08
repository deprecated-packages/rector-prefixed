<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use Rector\CakePHP\ValueObject\ArrayToFluentCall;
use Rector\CakePHP\ValueObject\FactoryMethod;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\ArrayToFluentCall('Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\FactoryMethod('Cake\\ORM\\Table', 'belongsTo', 'Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('Cake\\ORM\\Table', 'belongsToMany', 'Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('Cake\\ORM\\Table', 'hasMany', 'Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('Cake\\ORM\\Table', 'hasOne', 'Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('Cake\\ORM\\Table', 'find', 'Cake\\ORM\\Query', 2)])]]);
};
