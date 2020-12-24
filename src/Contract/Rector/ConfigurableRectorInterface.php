<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Contract\Rector;

interface ConfigurableRectorInterface
{
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void;
}
