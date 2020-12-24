<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScopere8e811afab72\\Doctrine\\Common\\Persistence\\ManagerRegistry', 'getConnection', '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityManagerInterface', 'getConfiguration', '_PhpScopere8e811afab72\\Doctrine\\ORM\\Configuration')])]]);
};
