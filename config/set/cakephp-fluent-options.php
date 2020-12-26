<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use Rector\CakePHP\ValueObject\ArrayToFluentCall;
use Rector\CakePHP\ValueObject\FactoryMethod;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\ArrayToFluentCall('RectorPrefix2020DecSat\\Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('RectorPrefix2020DecSat\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('RectorPrefix2020DecSat\\Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('RectorPrefix2020DecSat\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\FactoryMethod('RectorPrefix2020DecSat\\Cake\\ORM\\Table', 'belongsTo', 'RectorPrefix2020DecSat\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('RectorPrefix2020DecSat\\Cake\\ORM\\Table', 'belongsToMany', 'RectorPrefix2020DecSat\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('RectorPrefix2020DecSat\\Cake\\ORM\\Table', 'hasMany', 'RectorPrefix2020DecSat\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('RectorPrefix2020DecSat\\Cake\\ORM\\Table', 'hasOne', 'RectorPrefix2020DecSat\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('RectorPrefix2020DecSat\\Cake\\ORM\\Table', 'find', 'RectorPrefix2020DecSat\\Cake\\ORM\\Query', 2)])]]);
};
