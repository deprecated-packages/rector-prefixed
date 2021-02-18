<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class PropertyNodeParamTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    public function inferParam(\PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $classLike = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return new \PHPStan\Type\MixedType();
        }
        $paramName = $this->nodeNameResolver->getName($param);
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $propertyStaticTypes = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use($paramName, &$propertyStaticTypes) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->propertyFetchAnalyzer->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }
            /** @var Type|null $staticType */
            $staticType = $this->nodeTypeResolver->getStaticType($node->var);
            if ($staticType !== null) {
                $propertyStaticTypes[] = $staticType;
            }
            return null;
        });
        return $this->typeFactory->createMixedPassedOrUnionType($propertyStaticTypes);
    }
}
