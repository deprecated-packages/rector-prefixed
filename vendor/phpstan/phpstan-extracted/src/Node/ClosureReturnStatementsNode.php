<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\NodeAbstract;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult;
class ClosureReturnStatementsNode extends \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract implements \_PhpScoper0a6b37af0871\PHPStan\Node\ReturnStatementsNode
{
    /** @var \PhpParser\Node\Expr\Closure */
    private $closureExpr;
    /** @var \PHPStan\Node\ReturnStatement[] */
    private $returnStatements;
    /** @var StatementResult */
    private $statementResult;
    /**
     * @param \PhpParser\Node\Expr\Closure $closureExpr
     * @param \PHPStan\Node\ReturnStatement[] $returnStatements
     * @param \PHPStan\Analyser\StatementResult $statementResult
     */
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure $closureExpr, array $returnStatements, \_PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult $statementResult)
    {
        parent::__construct($closureExpr->getAttributes());
        $this->closureExpr = $closureExpr;
        $this->returnStatements = $returnStatements;
        $this->statementResult = $statementResult;
    }
    public function getClosureExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure
    {
        return $this->closureExpr;
    }
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array
    {
        return $this->returnStatements;
    }
    public function getStatementResult() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function returnsByRef() : bool
    {
        return $this->closureExpr->byRef;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClosureReturnStatementsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
