<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\StatementResult;
class MethodReturnStatementsNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\ReturnStatementsNode
{
    /** @var ClassMethod */
    private $classMethod;
    /** @var \PHPStan\Node\ReturnStatement[] */
    private $returnStatements;
    /** @var StatementResult */
    private $statementResult;
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $method
     * @param \PHPStan\Node\ReturnStatement[] $returnStatements
     * @param \PHPStan\Analyser\StatementResult $statementResult
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $method, array $returnStatements, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\StatementResult $statementResult)
    {
        parent::__construct($method->getAttributes());
        $this->classMethod = $method;
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
    public function getStatementResult() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function returnsByRef() : bool
    {
        return $this->classMethod->byRef;
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
