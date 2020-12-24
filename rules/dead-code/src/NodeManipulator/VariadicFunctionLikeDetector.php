<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function isVariadic(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        $isVariadic = \false;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$isVariadic) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isNames($node, self::VARIADIC_FUNCTION_NAMES)) {
                return null;
            }
            $isVariadic = \true;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isVariadic;
    }
}
