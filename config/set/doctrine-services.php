<?php

declare (strict_types=1);
namespace RectorPrefix20210117;

use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use RectorPrefix20210117\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210117\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', 'Doctrine\\DBAL\\Connection'), new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', 'Doctrine\\ORM\\Configuration')])]]);
};
