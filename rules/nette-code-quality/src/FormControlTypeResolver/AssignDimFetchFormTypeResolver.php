<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class AssignDimFetchFormTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        // traverse up and find all $this['some_name'] = $type
        /** @var Assign|null $formVariableAssign */
        $formVariableAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node);
        if ($formVariableAssign === null) {
            return [];
        }
        if (!$node->dim instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return [];
        }
        $exprType = $this->nodeTypeResolver->getStaticType($formVariableAssign->expr);
        if (!$exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $name = $node->dim->value;
        return [$name => $exprType->getClassName()];
    }
}
