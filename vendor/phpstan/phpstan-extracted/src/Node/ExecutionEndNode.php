<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
use _PhpScopere8e811afab72\PHPStan\Analyser\StatementResult;
class ExecutionEndNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var Node */
    private $node;
    /** @var StatementResult */
    private $statementResult;
    /** @var bool */
    private $hasNativeReturnTypehint;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\StatementResult $statementResult, bool $hasNativeReturnTypehint)
    {
        parent::__construct($node->getAttributes());
        $this->node = $node;
        $this->statementResult = $statementResult;
        $this->hasNativeReturnTypehint = $hasNativeReturnTypehint;
    }
    public function getNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->node;
    }
    public function getStatementResult() : \_PhpScopere8e811afab72\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function hasNativeReturnTypehint() : bool
    {
        return $this->hasNativeReturnTypehint;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ExecutionEndNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
