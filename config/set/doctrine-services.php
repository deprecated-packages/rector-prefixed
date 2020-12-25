<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper8b9c402c5f32\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoper8b9c402c5f32\\Doctrine\\DBAL\\Connection'), new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper8b9c402c5f32\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoper8b9c402c5f32\\Doctrine\\ORM\\Configuration')])]]);
};
