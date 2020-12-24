<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Contract;

use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set;
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
    public function provideByName(string $setName) : ?\_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set;
}
