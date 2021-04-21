<?php

declare(strict_types=1);

namespace Rector\Doctrine\Contract\PhpDoc\Node;

interface InversedByNodeInterface
{
    /**
     * @return string|null
     */
    public function getInversedBy();

    /**
     * @return void
     */
    public function removeInversedBy();
}
