<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor;
interface PhpRectorInterface extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor, \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface
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
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node;
}
