<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page']), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', [
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
    ]), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall('_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', ['fields' => 'select', 'conditions' => 'where', 'join' => 'join', 'order' => 'order', 'limit' => 'limit', 'offset' => 'offset', 'group' => 'group', 'having' => 'having', 'contain' => 'contain', 'page' => 'page'])]), \_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'belongsTo', '_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 2), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'belongsToMany', '_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 2), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'hasMany', '_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 2), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'hasOne', '_PhpScoperb75b35f52b74\\Cake\\ORM\\Association', 2), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod('_PhpScoperb75b35f52b74\\Cake\\ORM\\Table', 'find', '_PhpScoperb75b35f52b74\\Cake\\ORM\\Query', 2)])]]);
};
