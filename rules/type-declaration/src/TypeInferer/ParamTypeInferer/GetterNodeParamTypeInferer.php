<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterNodeParamTypeInferer extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    /**
     * @var PropertyFetchAssignManipulator
     */
    private $propertyFetchAssignManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator $propertyFetchAssignManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
        $this->propertyFetchAssignManipulator = $propertyFetchAssignManipulator;
    }
    public function inferParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $propertyNames = $this->propertyFetchAssignManipulator->getPropertyNamesOfAssignOfVariable($classMethod, $paramName);
        if ($propertyNames === []) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $returnType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        // resolve property assigns
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($propertyNames, &$returnType) : ?int {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr === null) {
                return null;
            }
            $isMatch = $this->propertyFetchManipulator->isLocalPropertyOfNames($node->expr, $propertyNames);
            if (!$isMatch) {
                return null;
            }
            // what is return type?
            /** @var ClassMethod|null $classMethod */
            $classMethod = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
            if (!$classMethod instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $classMethod->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            $methodReturnType = $phpDocInfo->getReturnType();
            if ($methodReturnType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                return null;
            }
            $returnType = $methodReturnType;
            return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $returnType;
    }
}
