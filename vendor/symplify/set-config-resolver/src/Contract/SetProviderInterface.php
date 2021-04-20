<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\SetConfigResolver\Contract;

use RectorPrefix20210420\Symplify\SetConfigResolver\ValueObject\Set;
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
    /**
     * @return \Symplify\SetConfigResolver\ValueObject\Set|null
     */
    public function provideByName(string $setName);
}
