<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\SideEffect;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class SideEffectNodeDetector
{
    /**
     * @var string[]
     */
    private const SIDE_EFFECT_NODE_TYPES = [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch::class];
    /**
     * @var PureFunctionDetector
     */
    private $pureFunctionDetector;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\DeadCode\SideEffect\PureFunctionDetector $pureFunctionDetector)
    {
        $this->pureFunctionDetector = $pureFunctionDetector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function detect(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        $exprStaticType = $this->nodeTypeResolver->resolve($expr);
        if ($exprStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType) {
            return \false;
        }
        foreach (self::SIDE_EFFECT_NODE_TYPES as $sideEffectNodeType) {
            if (\is_a($expr, $sideEffectNodeType, \true)) {
                return \false;
            }
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return !$this->pureFunctionDetector->detect($expr);
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            $variable = $this->resolveVariable($expr);
            // variables don't have side effects
            return !$variable instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
        }
        return \true;
    }
    private function resolveVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        while ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            $expr = $expr->var;
        }
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $expr;
    }
}
