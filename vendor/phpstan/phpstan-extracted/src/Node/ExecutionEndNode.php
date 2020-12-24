<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeAbstract;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult;
class ExecutionEndNode extends \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract implements \_PhpScoper0a6b37af0871\PHPStan\Node\VirtualNode
{
    /** @var Node */
    private $node;
    /** @var StatementResult */
    private $statementResult;
    /** @var bool */
    private $hasNativeReturnTypehint;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult $statementResult, bool $hasNativeReturnTypehint)
    {
        parent::__construct($node->getAttributes());
        $this->node = $node;
        $this->statementResult = $statementResult;
        $this->hasNativeReturnTypehint = $hasNativeReturnTypehint;
    }
    public function getNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->node;
    }
    public function getStatementResult() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult
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
