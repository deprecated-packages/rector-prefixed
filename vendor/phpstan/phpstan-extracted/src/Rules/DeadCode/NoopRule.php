<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\DeadCode;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class NoopRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var Standard */
    private $printer;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $originalExpr = $node->expr;
        $expr = $originalExpr;
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ErrorSuppress) {
            $expr = $expr->expr;
        }
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_ && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_ && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Expression "%s" on a separate line does not do anything.', $this->printer->prettyPrintExpr($originalExpr)))->line($expr->getLine())->identifier('deadCode.noopExpression')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
