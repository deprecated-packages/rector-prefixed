<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\StatementResult;
class ExecutionEndNode extends \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var Node */
    private $node;
    /** @var StatementResult */
    private $statementResult;
    /** @var bool */
    private $hasNativeReturnTypehint;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\StatementResult $statementResult, bool $hasNativeReturnTypehint)
    {
        parent::__construct($node->getAttributes());
        $this->node = $node;
        $this->statementResult = $statementResult;
        $this->hasNativeReturnTypehint = $hasNativeReturnTypehint;
    }
    public function getNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->node;
    }
    public function getStatementResult() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\StatementResult
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
