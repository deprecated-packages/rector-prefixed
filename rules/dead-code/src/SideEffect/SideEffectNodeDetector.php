<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\SideEffect;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class SideEffectNodeDetector
{
    /**
     * @var string[]
     */
    private const SIDE_EFFECT_NODE_TYPES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch::class];
    /**
     * @var PureFunctionDetector
     */
    private $pureFunctionDetector;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\DeadCode\SideEffect\PureFunctionDetector $pureFunctionDetector)
    {
        $this->pureFunctionDetector = $pureFunctionDetector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function detect(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        $exprStaticType = $this->nodeTypeResolver->resolve($expr);
        if ($exprStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType) {
            return \false;
        }
        foreach (self::SIDE_EFFECT_NODE_TYPES as $sideEffectNodeType) {
            if (\is_a($expr, $sideEffectNodeType, \true)) {
                return \false;
            }
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return !$this->pureFunctionDetector->detect($expr);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            $variable = $this->resolveVariable($expr);
            // variables don't have side effects
            return !$variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
        }
        return \true;
    }
    private function resolveVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        while ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            $expr = $expr->var;
        }
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $expr;
    }
}
