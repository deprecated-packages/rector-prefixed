<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector;

interface ConfigurableRectorInterface
{
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void;
}
