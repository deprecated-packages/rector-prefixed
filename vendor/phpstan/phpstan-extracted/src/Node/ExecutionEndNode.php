<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use PhpParser\Node;
use PhpParser\NodeAbstract;
use RectorPrefix20201227\PHPStan\Analyser\StatementResult;
class ExecutionEndNode extends \PhpParser\NodeAbstract implements \RectorPrefix20201227\PHPStan\Node\VirtualNode
{
    /** @var Node */
    private $node;
    /** @var StatementResult */
    private $statementResult;
    /** @var bool */
    private $hasNativeReturnTypehint;
    public function __construct(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\StatementResult $statementResult, bool $hasNativeReturnTypehint)
    {
        parent::__construct($node->getAttributes());
        $this->node = $node;
        $this->statementResult = $statementResult;
        $this->hasNativeReturnTypehint = $hasNativeReturnTypehint;
    }
    public function getNode() : \PhpParser\Node
    {
        return $this->node;
    }
    public function getStatementResult() : \RectorPrefix20201227\PHPStan\Analyser\StatementResult
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
