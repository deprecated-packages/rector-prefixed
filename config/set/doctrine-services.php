<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper0a6b37af0871\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoper0a6b37af0871\\Doctrine\\DBAL\\Connection'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoper0a6b37af0871\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Configuration')])]]);
};
