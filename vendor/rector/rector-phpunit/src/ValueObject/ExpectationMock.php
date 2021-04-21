<?php

declare (strict_types=1);
namespace Rector\PHPUnit\ValueObject;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
final class ExpectationMock
{
    /**
     * @var Variable|PropertyFetch
     */
    private $expectationVariable;
    /**
     * @var Arg[]
     */
    private $methodArguments = [];
    /**
     * @var int
     */
    private $index;
    /**
     * @var ?Expr
     */
    private $expr;
    /**
     * @var array<int, null|Expr>
     */
    private $withArguments = [];
    /**
     * @var Expression|null
     */
    private $originalExpression;
    /**
     * @param Variable|PropertyFetch $expectationVariable
     * @param Arg[] $methodArguments
     * @param array<int, null|Expr> $withArguments
     * @param \PhpParser\Node\Expr|null $expr
     * @param \PhpParser\Node\Stmt\Expression|null $originalExpression
     */
    public function __construct(\PhpParser\Node\Expr $expectationVariable, array $methodArguments, int $index, $expr, array $withArguments, $originalExpression)
    {
        $this->expectationVariable = $expectationVariable;
        $this->methodArguments = $methodArguments;
        $this->index = $index;
        $this->expr = $expr;
        $this->withArguments = $withArguments;
        $this->originalExpression = $originalExpression;
    }
    /**
     * @return Variable|PropertyFetch
     */
    public function getExpectationVariable() : \PhpParser\Node\Expr
    {
        return $this->expectationVariable;
    }
    /**
     * @return Arg[]
     */
    public function getMethodArguments() : array
    {
        return $this->methodArguments;
    }
    public function getIndex() : int
    {
        return $this->index;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function getReturn()
    {
        return $this->expr;
    }
    /**
     * @return array<int, null|Expr>
     */
    public function getWithArguments() : array
    {
        return $this->withArguments;
    }
    /**
     * @return \PhpParser\Node\Stmt\Expression|null
     */
    public function getOriginalExpression()
    {
        return $this->originalExpression;
    }
}
