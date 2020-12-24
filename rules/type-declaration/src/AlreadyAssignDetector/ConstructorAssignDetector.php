<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ConstructorAssignDetector extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\AbstractAssignDetector
{
    public function isPropertyAssigned(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $isAssignedInConstructor = \false;
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$isAssignedInConstructor) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            // is in constructor?
            $methodName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName !== \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                return null;
            }
            /** @var Assign $assign */
            $assign = $node;
            $isFirstLevelStatement = $assign->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT);
            // cannot be nested
            if ($isFirstLevelStatement !== \true) {
                return null;
            }
            $isAssignedInConstructor = \true;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        });
        return $isAssignedInConstructor;
    }
}
