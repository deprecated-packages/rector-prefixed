<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'belongsTo', '_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 2), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'belongsToMany', '_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 2), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'hasMany', '_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 2), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'hasOne', '_PhpScoper0a6b37af0871\\Cake\\ORM\\Association', 2), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoper0a6b37af0871\\Cake\\ORM\\Table', 'find', '_PhpScoper0a6b37af0871\\Cake\\ORM\\Query', 2)])]]);
};
