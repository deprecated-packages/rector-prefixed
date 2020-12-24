<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
use _PhpScopere8e811afab72\PHPStan\Analyser\StatementResult;
class FunctionReturnStatementsNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\ReturnStatementsNode
{
    /** @var Function_ */
    private $function;
    /** @var \PHPStan\Node\ReturnStatement[] */
    private $returnStatements;
    /** @var StatementResult */
    private $statementResult;
    /**
     * @param \PhpParser\Node\Stmt\Function_ $function
     * @param \PHPStan\Node\ReturnStatement[] $returnStatements
     * @param \PHPStan\Analyser\StatementResult $statementResult
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_ $function, array $returnStatements, \_PhpScopere8e811afab72\PHPStan\Analyser\StatementResult $statementResult)
    {
        parent::__construct($function->getAttributes());
        $this->function = $function;
        $this->returnStatements = $returnStatements;
        $this->statementResult = $statementResult;
    }
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array
    {
        return $this->returnStatements;
    }
    public function getStatementResult() : \_PhpScopere8e811afab72\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function returnsByRef() : bool
    {
        return $this->function->byRef;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_FunctionReturnStatementsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
