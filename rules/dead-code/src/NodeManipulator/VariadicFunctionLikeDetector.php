<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class VariadicFunctionLikeDetector
{
    /**
     * @var string[]
     */
    private const VARIADIC_FUNCTION_NAMES = ['func_get_arg', 'func_get_args', 'func_num_args'];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function isVariadic(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        $isVariadic = \false;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$isVariadic) : ?int {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isNames($node, self::VARIADIC_FUNCTION_NAMES)) {
                return null;
            }
            $isVariadic = \true;
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isVariadic;
    }
}
