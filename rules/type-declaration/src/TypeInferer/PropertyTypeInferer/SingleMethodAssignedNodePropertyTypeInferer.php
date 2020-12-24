<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class SingleMethodAssignedNodePropertyTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $classMethod = $classLike->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        $assignedNode = $this->resolveAssignedNodeToProperty($classMethod, $propertyName);
        if ($assignedNode === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->nodeTypeResolver->getStaticType($assignedNode);
    }
    public function getPriority() : int
    {
        return 750;
    }
    private function resolveAssignedNodeToProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $assignedNode = null;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$assignedNode) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node->var, $propertyName)) {
                return null;
            }
            $assignedNode = $node->expr;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $assignedNode;
    }
}
