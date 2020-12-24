<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver\Contract;

use _PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set;
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
    public function provideByName(string $setName) : ?\_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set;
}
