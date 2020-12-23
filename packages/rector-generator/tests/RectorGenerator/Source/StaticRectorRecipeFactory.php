<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Tests\RectorGenerator\Source;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoper0a2ac50786fa\Rector\Set\ValueObject\SetList;
final class StaticRectorRecipeFactory
{
    public static function createRectorRecipe(bool $isRectorRepository) : \_PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        $rectorRecipe = new \_PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe('Utils', 'WhateverRector', [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class], 'Change $service->arg(...) to $service->call(...)', <<<'CODE_SAMPLE'
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
        $rectorRecipe->setSet(\_PhpScoper0a2ac50786fa\Rector\Set\ValueObject\SetList::DEAD_CODE);
        return $rectorRecipe;
    }
}
