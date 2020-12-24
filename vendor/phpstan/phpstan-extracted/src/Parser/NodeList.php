<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PhpParser\Node;
class NodeList
{
    /** @var Node */
    private $node;
    /** @var self|null */
    private $next;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node $node, ?self $next = null)
    {
        $this->node = $node;
        $this->next = $next;
    }
    public function append(\_PhpScopere8e811afab72\PhpParser\Node $node) : self
    {
        $current = $this;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $new = new self($node);
        $current->next = $new;
        return $new;
    }
    public function getNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->node;
    }
    public function getNext() : ?self
    {
        return $this->next;
    }
}
