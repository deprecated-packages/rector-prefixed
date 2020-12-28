<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201228\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \RectorPrefix20201228\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('RectorPrefix20201228\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', 'RectorPrefix20201228\\Doctrine\\DBAL\\Connection'), new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('RectorPrefix20201228\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', 'RectorPrefix20201228\\Doctrine\\ORM\\Configuration')])]]);
};
