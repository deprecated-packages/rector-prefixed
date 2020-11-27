<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use Rector\CakePHP\ValueObject\ArrayToFluentCall;
use Rector\CakePHP\ValueObject\FactoryMethod;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper26e51eeacccf\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', [
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
    ]), new \Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper26e51eeacccf\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper26e51eeacccf\\Cake\\ORM\\Table', 'belongsTo', '_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper26e51eeacccf\\Cake\\ORM\\Table', 'belongsToMany', '_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper26e51eeacccf\\Cake\\ORM\\Table', 'hasMany', '_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper26e51eeacccf\\Cake\\ORM\\Table', 'hasOne', '_PhpScoper26e51eeacccf\\Cake\\ORM\\Association', 2), new \Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper26e51eeacccf\\Cake\\ORM\\Table', 'find', '_PhpScoper26e51eeacccf\\Cake\\ORM\\Query', 2)])]]);
};
