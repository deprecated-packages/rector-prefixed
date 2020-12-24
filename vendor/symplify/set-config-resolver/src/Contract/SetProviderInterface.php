<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract;

use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\ValueObject\Set;
interface SetProviderInterface
{
    /**
     * @return Set[]
     */
    public function provide() : array;
    /**
     * @return string[]
     */
    public function provideSetNames() : array;
    public function provideByName(string $setName) : ?\_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\ValueObject\Set;
}
