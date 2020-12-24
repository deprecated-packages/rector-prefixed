<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class PropertyNodeParamTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function inferParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $paramName = $this->nodeNameResolver->getName($param);
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $propertyStaticTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($paramName, &$propertyStaticTypes) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->propertyFetchManipulator->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }
            /** @var Assign $node */
            $staticType = $this->nodeTypeResolver->getStaticType($node->var);
            /** @var Type|null $staticType */
            if ($staticType !== null) {
                $propertyStaticTypes[] = $staticType;
            }
            return null;
        });
        return $this->typeFactory->createMixedPassedOrUnionType($propertyStaticTypes);
    }
}
