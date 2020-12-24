<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor;
interface PhpRectorInterface extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitor, \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * List of nodes this class checks, classes that implements \PhpParser\Node
     * See beautiful map of all nodes https://github.com/rectorphp/rector/blob/master/docs/nodes_overview.md
     *
     * @return class-string[]
     */
    public function getNodeTypes() : array;
    /**
     * Process Node of matched type
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node;
}
