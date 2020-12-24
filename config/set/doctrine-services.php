<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoper2a4e7ab1ecbc\\Doctrine\\DBAL\\Connection'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Configuration')])]]);
};
