<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector;

interface ConfigurableRectorInterface
{
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void;
}
