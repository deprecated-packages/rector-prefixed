<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class PropertyNodeParamTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function inferParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $paramName = $this->nodeNameResolver->getName($param);
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $propertyStaticTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($paramName, &$propertyStaticTypes) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
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
