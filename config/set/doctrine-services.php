<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Configuration')])]]);
};
