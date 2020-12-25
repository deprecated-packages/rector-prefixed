<?php

declare (strict_types=1);
namespace PHPStan\Rules\DeadCode;

use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class NoopRule implements \PHPStan\Rules\Rule
{
    /** @var Standard */
    private $printer;
    public function __construct(\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $originalExpr = $node->expr;
        $expr = $originalExpr;
        if ($expr instanceof \PhpParser\Node\Expr\Cast || $expr instanceof \PhpParser\Node\Expr\UnaryMinus || $expr instanceof \PhpParser\Node\Expr\UnaryPlus || $expr instanceof \PhpParser\Node\Expr\ErrorSuppress) {
            $expr = $expr->expr;
        }
        if (!$expr instanceof \PhpParser\Node\Expr\Variable && !$expr instanceof \PhpParser\Node\Expr\PropertyFetch && !$expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch && !$expr instanceof \PhpParser\Node\Expr\NullsafePropertyFetch && !$expr instanceof \PhpParser\Node\Expr\ArrayDimFetch && !$expr instanceof \PhpParser\Node\Scalar && !$expr instanceof \PhpParser\Node\Expr\Isset_ && !$expr instanceof \PhpParser\Node\Expr\Empty_ && !$expr instanceof \PhpParser\Node\Expr\ConstFetch && !$expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Expression "%s" on a separate line does not do anything.', $this->printer->prettyPrintExpr($originalExpr)))->line($expr->getLine())->identifier('deadCode.noopExpression')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
