<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\DeadCode;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\PrettyPrinter\Standard;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class NoopRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var Standard */
    private $printer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $originalExpr = $node->expr;
        $expr = $originalExpr;
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ErrorSuppress) {
            $expr = $expr->expr;
        }
        if (!$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\NullsafePropertyFetch && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Isset_ && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Empty_ && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch && !$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Expression "%s" on a separate line does not do anything.', $this->printer->prettyPrintExpr($originalExpr)))->line($expr->getLine())->identifier('deadCode.noopExpression')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
