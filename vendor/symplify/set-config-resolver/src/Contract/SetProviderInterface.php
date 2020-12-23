<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Contract;

use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\ValueObject\Set;
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
    public function provideByName(string $setName) : ?\_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\ValueObject\Set;
}
