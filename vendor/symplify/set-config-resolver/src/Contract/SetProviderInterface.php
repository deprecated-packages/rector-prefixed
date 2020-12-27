<?php

declare (strict_types=1);
namespace RectorPrefix20201227\Symplify\SetConfigResolver\Contract;

use RectorPrefix20201227\Symplify\SetConfigResolver\ValueObject\Set;
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
    public function provideByName(string $setName) : ?\RectorPrefix20201227\Symplify\SetConfigResolver\ValueObject\Set;
}
