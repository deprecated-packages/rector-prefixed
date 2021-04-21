<?php

declare(strict_types=1);

namespace Symplify\Astral\Contract;

use PhpParser\Node;

interface NodeNameResolverInterface
{
    public function match(Node $node): bool;

    /**
     * @return string|null
     */
    public function resolve(Node $node);
}
