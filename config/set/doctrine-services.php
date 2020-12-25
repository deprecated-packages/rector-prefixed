<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper50d83356d739\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoper50d83356d739\\Doctrine\\DBAL\\Connection'), new \Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper50d83356d739\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoper50d83356d739\\Doctrine\\ORM\\Configuration')])]]);
};
