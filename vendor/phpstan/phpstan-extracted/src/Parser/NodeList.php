<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
class NodeList
{
    /** @var Node */
    private $node;
    /** @var self|null */
    private $next;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node $node, ?self $next = null)
    {
        $this->node = $node;
        $this->next = $next;
    }
    public function append(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : self
    {
        $current = $this;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $new = new self($node);
        $current->next = $new;
        return $new;
    }
    public function getNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->node;
    }
    public function getNext() : ?self
    {
        return $this->next;
    }
}
