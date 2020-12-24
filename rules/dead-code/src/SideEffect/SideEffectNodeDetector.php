<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\SideEffect;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class SideEffectNodeDetector
{
    /**
     * @var string[]
     */
    private const SIDE_EFFECT_NODE_TYPES = [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch::class];
    /**
     * @var PureFunctionDetector
     */
    private $pureFunctionDetector;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\DeadCode\SideEffect\PureFunctionDetector $pureFunctionDetector)
    {
        $this->pureFunctionDetector = $pureFunctionDetector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function detect(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        $exprStaticType = $this->nodeTypeResolver->resolve($expr);
        if ($exprStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType) {
            return \false;
        }
        foreach (self::SIDE_EFFECT_NODE_TYPES as $sideEffectNodeType) {
            if (\is_a($expr, $sideEffectNodeType, \true)) {
                return \false;
            }
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return !$this->pureFunctionDetector->detect($expr);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            $variable = $this->resolveVariable($expr);
            // variables don't have side effects
            return !$variable instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
        }
        return \true;
    }
    private function resolveVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        while ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            $expr = $expr->var;
        }
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $expr;
    }
}
