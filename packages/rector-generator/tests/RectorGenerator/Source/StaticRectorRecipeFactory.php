<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Tests\RectorGenerator\Source;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Rector\Set\ValueObject\SetList;
final class StaticRectorRecipeFactory
{
    public static function createRectorRecipe(bool $isRectorRepository) : \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        $rectorRecipe = new \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe('Utils', 'WhateverRector', [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class], 'Change $service->arg(...) to $service->call(...)', <<<'CODE_SAMPLE'
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(SomeClass::class)
        ->arg('$key', 'value');
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(SomeClass::class)
        ->call('configure', [[
            '$key' => 'value'
        ]]);
}
CODE_SAMPLE
);
        $rectorRecipe->setConfiguration(['CLASS_TYPE_TO_METHOD_NAME' => ['SomeClass' => 'configure']]);
        $rectorRecipe->setIsRectorRepository($isRectorRepository);
        if ($isRectorRepository) {
            $rectorRecipe->setPackage('ModeratePackage');
        }
        $rectorRecipe->setSet(\_PhpScopere8e811afab72\Rector\Set\ValueObject\SetList::DEAD_CODE);
        return $rectorRecipe;
    }
}
