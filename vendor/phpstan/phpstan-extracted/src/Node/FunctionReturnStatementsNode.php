<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeAbstract;
use RectorPrefix20201227\PHPStan\Analyser\StatementResult;
class FunctionReturnStatementsNode extends \PhpParser\NodeAbstract implements \RectorPrefix20201227\PHPStan\Node\ReturnStatementsNode
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
    public function __construct(\PhpParser\Node\Stmt\Function_ $function, array $returnStatements, \RectorPrefix20201227\PHPStan\Analyser\StatementResult $statementResult)
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
    public function getStatementResult() : \RectorPrefix20201227\PHPStan\Analyser\StatementResult
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
