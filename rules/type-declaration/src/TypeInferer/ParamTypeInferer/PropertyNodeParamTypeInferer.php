<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class PropertyNodeParamTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $paramName = $this->nodeNameResolver->getName($param);
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $propertyStaticTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($paramName, &$propertyStaticTypes) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
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
