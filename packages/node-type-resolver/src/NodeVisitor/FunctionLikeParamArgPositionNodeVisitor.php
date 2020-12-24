<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionLikeParamArgPositionNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @return Node
     */
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike) {
            foreach ($node->getParams() as $position => $param) {
                $param->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARAMETER_POSITION, $position);
            }
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            foreach ($node->args as $position => $arg) {
                $arg->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION, $position);
            }
        }
        return $node;
    }
}
