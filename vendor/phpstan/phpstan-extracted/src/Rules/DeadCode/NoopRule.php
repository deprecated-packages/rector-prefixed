<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\DeadCode;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class NoopRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var Standard */
    private $printer;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $originalExpr = $node->expr;
        $expr = $originalExpr;
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ErrorSuppress) {
            $expr = $expr->expr;
        }
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_ && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Empty_ && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Expression "%s" on a separate line does not do anything.', $this->printer->prettyPrintExpr($originalExpr)))->line($expr->getLine())->identifier('deadCode.noopExpression')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
