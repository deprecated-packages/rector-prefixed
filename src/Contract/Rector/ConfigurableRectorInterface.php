<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector;

interface ConfigurableRectorInterface
{
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void;
}
