<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection'), new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\Configuration')])]]);
};
