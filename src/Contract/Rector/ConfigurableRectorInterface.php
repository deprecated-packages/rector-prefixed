<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector;

interface ConfigurableRectorInterface
{
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void;
}
