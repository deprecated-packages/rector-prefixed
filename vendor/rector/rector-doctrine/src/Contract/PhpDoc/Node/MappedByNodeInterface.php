<?php

declare(strict_types=1);

namespace Rector\Doctrine\Contract\PhpDoc\Node;

interface MappedByNodeInterface
{
    /**
     * @return string|null
     */
    public function getMappedBy();

    /**
     * @return void
     */
    public function removeMappedBy();
}
