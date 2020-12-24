<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
class NodeList
{
    /** @var Node */
    private $node;
    /** @var self|null */
    private $next;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node $node, ?self $next = null)
    {
        $this->node = $node;
        $this->next = $next;
    }
    public function append(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : self
    {
        $current = $this;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $new = new self($node);
        $current->next = $new;
        return $new;
    }
    public function getNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->node;
    }
    public function getNext() : ?self
    {
        return $this->next;
    }
}
