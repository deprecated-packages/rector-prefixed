<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class SingleMethodAssignedNodePropertyTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    public function inferProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $classMethod = $classLike->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        $assignedNode = $this->resolveAssignedNodeToProperty($classMethod, $propertyName);
        if ($assignedNode === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->nodeTypeResolver->getStaticType($assignedNode);
    }
    public function getPriority() : int
    {
        return 750;
    }
    private function resolveAssignedNodeToProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $assignedNode = null;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName, &$assignedNode) : ?int {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node->var, $propertyName)) {
                return null;
            }
            $assignedNode = $node->expr;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $assignedNode;
    }
}
