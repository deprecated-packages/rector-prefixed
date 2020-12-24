<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterNodeParamTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    /**
     * @var PropertyFetchAssignManipulator
     */
    private $propertyFetchAssignManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator $propertyFetchAssignManipulator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
        $this->propertyFetchAssignManipulator = $propertyFetchAssignManipulator;
    }
    public function inferParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $propertyNames = $this->propertyFetchAssignManipulator->getPropertyNamesOfAssignOfVariable($classMethod, $paramName);
        if ($propertyNames === []) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $returnType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        // resolve property assigns
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyNames, &$returnType) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
                return null;
            }
            $isMatch = $this->propertyFetchManipulator->isLocalPropertyOfNames($node->expr, $propertyNames);
            if (!$isMatch) {
                return null;
            }
            // what is return type?
            /** @var ClassMethod|null $classMethod */
            $classMethod = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
            if (!$classMethod instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            $methodReturnType = $phpDocInfo->getReturnType();
            if ($methodReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                return null;
            }
            $returnType = $methodReturnType;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $returnType;
    }
}
